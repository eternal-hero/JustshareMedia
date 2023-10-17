<?php

namespace App\Http\Controllers;

use App\Helpers\AuthorizeNet;
use App\Helpers\LicensedVideosHoldPeriod;
use App\Models\AdditionalLicense;
use App\Models\GalleryItem;
use App\Models\LicensedVideo;
use App\Models\OperateLocation;
use App\Models\TaxRate;
use App\Models\User;
use App\Models\VideoTemplates;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileParams;
use App\Services\Payment\CustomerProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Symfony\Component\HttpFoundation\Response;

class VideoCustomiserController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function videoCustomize($id, $type)
    {
        /**
         * @var $user User
         */

        $user = \Auth::user();

        // TODO Refactor, Initial check
        if ($type === 'subscription') {
            if (!$user->canEditVideo()) {
                return redirect(route('public.gallery'));
            }
        } else {
            $hasAdditionalVideo = AdditionalLicense::where('user_id', $user->id)
                ->where('video_id', $id)->where('status', AdditionalLicense::STATUS_AVAILABLE)->first();
            if (!$hasAdditionalVideo) {
                return redirect(route('public.gallery'));
            }
        }

        $activeOrder = $user->activeOrder();
        if (empty($activeOrder) || $activeOrder->status != 'active') {
            return redirect(route('signup'));
        }
        $video = GalleryItem::find($id);
        $brandColors = $user->colors ? $user->colors : [];
        $hasBrandColors = false;
        foreach ($brandColors as $color) {
            if ($color['value']) {
                $hasBrandColors = true;
            }
        }
        $params = $user->video_render_parameters;
        $defaultTemplates = VideoTemplates::where('user_id', null)->where('type', null)->orWhere(function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('type', null);
        })->orderby('created_at', 'desc')->get();
        $customTemplates = VideoTemplates::where('type', 'custom')->where('user_id', $user->id)->where('saved', true)->orderby('created_at', 'desc')->get();
        $logo = !empty($params['logo']) ? $params['logo'] : null;

        $logoWidth = 0;
        $logoHeight = 0;

        if ($logo) {
            $logoImage = \Intervention\Image\Facades\Image::make(storage_path('app/' . $logo));
//            $logoWidth = $logoImage->getWidth() * 0.65;
//            $logoHeight = $logoImage->getHeight() * 0.65;
            $logoWidth = $logoImage->getWidth();
            $logoHeight = $logoImage->getHeight();
            $logoImage->destroy();
        }

        $selectedTemplate = !empty($params['template']) ? VideoTemplates::find($params['template']) : null;

        return view('video-customizer', compact(
                'video',
                'user',
                'defaultTemplates',
                'customTemplates',
                'logo',
                'logoWidth',
                'logoHeight',
                'selectedTemplate',
                'brandColors',
                'hasBrandColors',
                'type'
            )
        );
    }

    /**
     * @param Request $request
     * @param int $videoId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function processLogo(Request $request, int $videoId): \Illuminate\Http\JsonResponse
    {
        $request->validate(['logo_file' => 'required|image']);

        $user = \Auth::user();
        File::makeDirectory(Storage::path('public/video_temp/user_' . $user->id), 0777, true, true);

        $logo = $request->file('logo_file')->storeAs('public/video_temp/user_' . $user->id, 'processed_logo.png');
        $logoImage = Image::load(Storage::path($logo));
        $logoImage->width(400);
        $logoImage->height(200);
        $logoImage->save(Storage::path($logo));

        return response()->json([
            'status' => true,
            'logoUrl' => Storage::url($logo),
            'path' => $logo,
            'width' => $logoImage->getWidth(),
            'height' => $logoImage->getHeight()
        ], Response::HTTP_OK);
    }

    public function submitTemplate(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = \Auth::user();
        $requestedTemplate = json_decode(request()->getContent(), true);
        list($type, $imageWLogo) = explode(';', $requestedTemplate['template']);
        list(, $imageWLogo) = explode(',', $imageWLogo);
        $templateImage = base64_decode($imageWLogo);
        $resizedTemplate = \Intervention\Image\Facades\Image::make($templateImage)->resize(1080, 1080)->stream('png');
        list($type, $imageWOLogo) = explode(';', $requestedTemplate['preview']);
        list(, $imageWOLogo) = explode(',', $imageWOLogo);
        $previewImage = base64_decode($imageWOLogo);
        $resizedPreview = \Intervention\Image\Facades\Image::make($previewImage)->resize(140, 140)->stream('png');
        $time = time();
        $templatePath = 'video_templates/user_' . $user->id . '/video_' . $requestedTemplate['video'] . '/' . $time . '.png';
        $previewPath = 'video_templates/user_' . $user->id . '/video_' . $requestedTemplate['video'] . '/' . $time . '_preview.png';
        File::makeDirectory(Storage::path('public/video_templates/user_' . $user->id . '/video_' . $requestedTemplate['video'] . '/'), 0777, true, true);
        Storage::disk('public')->put($templatePath, $resizedTemplate);
        Storage::disk('public')->put($previewPath, $resizedPreview);
        $template = new VideoTemplates();
        $template->title = 'Custom template';
        $template->user_id = $user->id;
        $template->path = 'public/' . $templatePath;
        $template->preview_path = 'public/' . $previewPath;
        $template->editorData = $requestedTemplate['appData'];
        $template->saved = $requestedTemplate['templateType'] == 'custom' && $requestedTemplate['shouldSaveTemplate'];
        $template->type = $requestedTemplate['templateType'];
        $template->save();
        $templateID = $template->id;
        /**
         * @var $user User
         */
        $user = \Auth::user();
        $user->video_render_parameters = [
            'logo' => $requestedTemplate['logo'],
            'template' => $templateID,
            'video_id' => $requestedTemplate['video'],
        ];
        $user->save();

        return \response()->json(['status' => true], Response::HTTP_OK);
    }

    public function deleteTemplate(Request $request)
    {
        $requestedTemplate = json_decode(request()->getContent(), true);
        $user = \Auth::user();
        $template = VideoTemplates::find($requestedTemplate['id']);
        if ($user->id != $template->user_id) {
            return;
        }

        $template->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function attachLocations(Request $request, $licenseType, $video_id = null)
    {
        /**
         * @var $user User
         */
        $user = \Auth::user();
        $params = $user->video_render_parameters;
        $logo = !empty($params['logo']) ? $params['logo'] : null;
        $selectedTemplate = !empty($params['template']) ? VideoTemplates::find($params['template']) : null;
        $notAttachedLocations = $user->getNotAttachedOperationalLocations($params['video_id']);

        $notFilteredLocations = [];
        foreach ($notAttachedLocations as $location) {
            $mappedLocation = new \stdClass();
            $mappedLocation->id = $location->id;
            $mappedLocation->latitude = $location->lat;
            $mappedLocation->longitude = $location->lng;
            $excluded_videos = LicensedVideosHoldPeriod::excludedVideosForLocations([$mappedLocation]);
            if (!in_array($params['video_id'], $excluded_videos)) {
                $notFilteredLocations[] = $location;
            }
        }

        //remove prohibited locations for the video
        $galleryItem = GalleryItem::find($params['video_id']);
        $filteredLocations = [];
        foreach ($notFilteredLocations as $location) {
            $prohibited = false;
            foreach ($galleryItem->prohibitedLocations as $prohibitedLocation) {
                $prohibitedLocationPoint = new \stdClass();
                $prohibitedLocationPoint->latitude = $prohibitedLocation->lat;
                $prohibitedLocationPoint->longitude = $prohibitedLocation->lng;
                $locationPoint = new \stdClass();
                $locationPoint->latitude = $location->lat;
                $locationPoint->longitude = $location->lng;
                if (OperateLocation::calculateDistance($prohibitedLocationPoint, $locationPoint) < config('app.distance')) {
                    $prohibited = true;
                }
            }
            if (!$prohibited) {
                $filteredLocations[] = $location;
            }
        }
        if (count($filteredLocations)) {
            $locations = $filteredLocations;
        } else {
            $locations = $notFilteredLocations;
        }


        $drawAll = false;
        return view('choose-location', compact('user', 'logo', 'selectedTemplate', 'locations', 'drawAll', 'video_id', 'licenseType'));
    }

    public function redrawLocationsCheckboxes(Request $request)
    {
        $notFilteredLocations = \Auth::user()->getNotAttachedOperationalLocations($request->post('videoId'), [$request->post('selectedLocation')]);

        $galleryItem = GalleryItem::find($request->post('videoId'));
        $filteredLocations = [];
        foreach ($notFilteredLocations as $location) {
            $prohibited = false;
            foreach ($galleryItem->prohibitedLocations as $prohibitedLocation) {
                $prohibitedLocationPoint = new \stdClass();
                $prohibitedLocationPoint->latitude = $prohibitedLocation->lat;
                $prohibitedLocationPoint->longitude = $prohibitedLocation->lng;
                $locationPoint = new \stdClass();
                $locationPoint->latitude = $location->lat;
                $locationPoint->longitude = $location->lng;
                if (OperateLocation::calculateDistance($prohibitedLocationPoint, $locationPoint) < config('app.distance')) {
                    $prohibited = true;
                }
            }
            if (!$prohibited) {
                $filteredLocations[] = $location;
            }
        }
        if (count($filteredLocations)) {
            $locations = $filteredLocations;
        } else {
            $locations = $notFilteredLocations;
        }

        $view = (view('components.locations-checkboxes', ['locations' => $locations, 'drawAll' => true]))->render();
        return \response()->json(['html' => $view], Response::HTTP_OK);
    }

    public function addLocationsPost(Request $request, CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository)
    {
        /**
         * @var $user User
         */
        $savedCard = $request->input('saved_card');
        $user = \Auth::user();
        $additional_location = $request->post('additional_location');

        $userId = $user->id;
        $videoId = !empty($request->post('video_id')) ? $request->post('video_id') : $user->video_render_parameters['video_id'];
        $locationId = $request->post('free_location');

        if (!$additional_location && !$locationId) {
            return response()->json(['status' => false, 'message' => 'You should chose at least one location'], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($additional_location) && count($additional_location)) {
            if ($savedCard == 0) {
                $request->validate([
                    'cardnumber' => 'required|digits_between:13,19',
                    'expmonth' => 'required',
                    'expyear' => 'required',
                    'cvv' => 'required',
                ]);
            }

            $locationPrice = config('app.additional_location_license_amount');
            $quantity = count($additional_location);
            $amount = $locationPrice * $quantity;
            $tax = TaxRate::getTaxRate($user->state);
            $totalTax = $amount * $tax / 100;
            $order = $user->activeOrder();
            $location = OperateLocation::find($locationId);
            $video = GalleryItem::find($videoId);
            $fullAmount = number_format($amount + $totalTax, 2);

            $desc = 'Attach location(s) ';
            $locs = [];
            foreach ($additional_location as $al) {
                $l = OperateLocation::find($al);
                $locs[] = $l->name;
            }
            $desc .= implode(', ', $locs) . ' to video ' . $video->title;
            if ($savedCard == 1) {
                $chargeResponse = $customerProfileService->charge($user, $fullAmount, $order, $desc);
                if (!$chargeResponse->isSuccessful()) {
                    return response()->json(['response' => false, 'message' => $chargeResponse->getMessage()], Response::HTTP_BAD_REQUEST);
                }
            } else {
                $customerParams = new CustomerProfileParams();
                $customerParams->setUser($user);
                $customerParams->setCardNumber($request->post('cardnumber'));
                $customerParams->setExpirationDate($request->input('expyear') . '-' . $request->input('expmonth'));
                $customerParams->setCVV($request->post('cvv'));
//                $description = 'Attach location ' . $location->name . ' to video ' . $video->title;
                $chargeResponse = $customerProfileService->chargeCard($customerParams, $order, $fullAmount, $desc);
                if (!$chargeResponse->isSuccessful()) {
                    return response()->json(['response' => false, 'message' => $chargeResponse->getMessage()], Response::HTTP_BAD_REQUEST);
                }
            }
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $order);

            foreach ($additional_location as $location) {
                $licensedVideo = new LicensedVideo();
                $licensedVideo->user_id = $userId;
                $licensedVideo->video_id = $videoId;
                $licensedVideo->location_id = $location;
                $licensedVideo->type = LicensedVideo::PAID;
                $licensedVideo->save();
            }
            $order->addItem('location', 'Add Location - ' . $licensedVideo->getOperateLocationsNames($additional_location), $amount, $transaction->id, ['video_id' => $videoId, 'location_id' => $location]);
            $order->addItem('tax', 'Sales Tax @ ' . $tax . '%', $totalTax, $transaction->id);
            $order->setTotal($order->getTotal() + $fullAmount);
        }

        /**
         * @var $licensedVideo LicensedVideo
         */
        if (!empty($locationId)) {
            $licensedVideo = new LicensedVideo();
            $licensedVideo->user_id = $userId;
            $licensedVideo->video_id = $videoId;
            $licensedVideo->location_id = $locationId;
            if ($request->licence_type == 'additional') {
                $licensedVideo->type = LicensedVideo::ADDITIONAL;
                $additionalLicence = AdditionalLicense::where('user_id', $userId)->where('video_id', $videoId)->where('status', AdditionalLicense::STATUS_AVAILABLE)->first();
                $additionalLicence->status = AdditionalLicense::STATUS_USED;
                $additionalLicence->save();
            } else {
                $licensedVideo->type = LicensedVideo::FREE;
            }

            $licensedVideo->save();
        }

        return response()->json(['status' => true], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $video_id
     */
    public function renderVideo()
    {
        GalleryItem::processVideo('big');
        GalleryItem::processVideo('small');

        return \response()->json([], Response::HTTP_OK);
    }

    public function videoReady()
    {
        return view('video-ready');
    }

    /**
     * @param $video_id
     * @param $location_id
     * @param $size
     * @return mixed
     */
    public function downloadLicensedVideo($video_id, $location_id, $size)
    {
        $user = \Auth::user();
        $videoSize = $size == 'big' ? 'wide_video' : 'square_video';
        $filename = $videoSize . $user->id . $video_id . '.mp4';
        $file_path = Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video_id . '/' . $size . 'FinalVideo.mp4');

        $headers = array(
            'Content-Type: application/mp4',
            'Content-Disposition: attachment; filename=' . $filename . '.mp4',
        );
        if (file_exists($file_path)) {

            $licensedVideo = LicensedVideo::where('user_id', $user->id)->where('video_id', $video_id)->where('location_id', $location_id)->first();
            $licensedVideo->increment($size . '_download_attempts');
            $licensedVideo->save();
            // Send Download
            return \Response::download($file_path, $filename, $headers);
        } else {
            // Error
            exit('Requested file does not exist on our server!');
        }
    }
}
