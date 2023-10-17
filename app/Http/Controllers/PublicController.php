<?php

namespace App\Http\Controllers;

use App\Helpers\LicensedVideosHoldPeriod;
use App\Models\AdditionalLicense;
use App\Models\GalleryItem;
use App\Models\LicensedVideo;
use App\Models\OperateLocation;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Licensing\LicenseDates;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class PublicController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function gallery(LicenseDates $licenseDates)
    {


        /**
         * @var $user User
         */

        $user = \Auth::user();
        $subscription = false;

        if ($user) {


            $operateLocations = OperateLocation::where('user_id', $user->id)->get();
            $fname = $user->first_name;
            $lname = $user->last_name;
            $company = $user->company;
            $phone = $user->phone;
            $address = $user->address;
            $city = $user->city;
            $hasOperateLocation = count($operateLocations) ? true : false;
            if ($fname == '' || $lname == '' || $company == '' || $phone == '' || $address == '' || $city == '' || !$hasOperateLocation) {
                return redirect()->route('dashboard.profile');
            }
        }




        if ($user) {
            $subscription = Subscription::where('user_id', $user->id)->first();
            if(!$subscription) {
                Log::error('No subscription on gallery, UID: ' . $user->id);
                throw new \Exception(500);
            }
            /*            $subscription = $user->getSubscribtions();
                        if (empty($subscription) || $subscription->status != 'active') {
                            return redirect(route('signup'));
                        }*/
            $hasUnusedAdditionalVideo = AdditionalLicense::where('user_id', $user->id)->where('status', AdditionalLicense::STATUS_AVAILABLE)->first();

            $locations = $user->getAllUserLocations();
            $shingleTypes = GalleryItem::getAllShingleTypes();
            $daysLeftUntilNewLicense = $licenseDates->daysUntilNewLicenseIsAvailable($user);

            $newLicenseAvailableAt = $licenseDates->renewalDate($user);
            if ($newLicenseAvailableAt) {
                $newLicenseAvailableAt = $newLicenseAvailableAt->format('Y-m-d');
            } else {
                $newLicenseAvailableAt = 'unpaid';
            }

            return view('gallery', compact('locations', 'shingleTypes', 'daysLeftUntilNewLicense', 'newLicenseAvailableAt', 'hasUnusedAdditionalVideo', 'subscription'));
        }

        return view('gallery');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryAjax(Request $request)
    {
        $skip = $request->post('isInitialAjaxGalleryRequest') == 1 ? 0 : ($request->post('page') - 2) * 3 + 9;
        $limit = $request->post('isInitialAjaxGalleryRequest') == 1 ? 9 : 3;
        $types = $request->post('types', []);
        $locationsFromPost = OperateLocation::whereIn('id', $request->post('locations', []))->get();

        $data = [];

        if (count($types) && count($locationsFromPost)) {

            $videoIdsToExclude = LicensedVideosHoldPeriod::excludedVideosForLocations($locationsFromPost);
            $allGalerryItems = GalleryItem::all();
            foreach ($allGalerryItems as $video) {
                foreach ($video->prohibitedLocations as $prohibitedLocation) {
                    foreach ($locationsFromPost as $requestedLocation) {
                        $prohibitedLocationPoint = new \stdClass();
                        $prohibitedLocationPoint->latitude = $prohibitedLocation->lat;
                        $prohibitedLocationPoint->longitude = $prohibitedLocation->lng;
                        $prohibitedRequestLocationPoint = new \stdClass();
                        $prohibitedRequestLocationPoint->latitude = $requestedLocation->latitude;
                        $prohibitedRequestLocationPoint->longitude = $requestedLocation->longitude;
                        if (OperateLocation::calculateDistance($prohibitedLocationPoint, $prohibitedRequestLocationPoint) < config('app.distance')) {
                            $videoIdsToExclude[] = $video->id;
                        }
                    }
                }
            }

            $data = \App\Models\GalleryItem::where('public', 0)
                ->whereIn('shingle_type', $types)
                ->whereNotIn('id', $videoIdsToExclude)
                ->orderBy('created_at', 'DESC')->skip($skip)->limit($limit)->get();

            $count = \App\Models\GalleryItem::where('public', 0)
                ->whereIn('shingle_type', $types)
                ->whereNotIn('id', $videoIdsToExclude)
                ->orderBy('created_at', 'DESC')->count();

            $lastPage = ceil(($count - 9) / 3) + 1 > 1 ? ceil(($count - 9) / 3) + 1 : 1;
        }

        $view = (view('components.gallery-ajax', ['data' => $data]))->render();
        return \response()->json(['html' => $view, 'data' => $data, 'last_page' => $lastPage, 'page' => $request->post('page')], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryGuestAjax(Request $request)
    {
        $skip = $request->post('isInitialAjaxGalleryRequest') == 1 ? 0 : ($request->post('page') - 2) * 3 + 9;
        $limit = $request->post('isInitialAjaxGalleryRequest') == 1 ? 9 : 3;
        $data = \App\Models\GalleryItem::where('public', 0)
            ->orderBy('created_at', 'DESC')
            ->skip($skip)->limit($limit)->get();

        $count = \App\Models\GalleryItem::where('public', 0)
            ->orderBy('created_at', 'DESC')->count();

        $lastPage = ceil(($count - 9) / 3) + 1 > 1 ? ceil(($count - 9) / 3) + 1 : 1;

        $view = (view('components.gallery-ajax', ['data' => $data]))->render();
        return \response()->json(['html' => $view, 'data' => $data, 'last_page' => $lastPage, 'page' => $request->post('page')], Response::HTTP_OK);
    }

}
