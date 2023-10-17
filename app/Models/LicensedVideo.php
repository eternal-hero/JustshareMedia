<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class LicensedVideo
 * @package App\Models
 *
 * @property $id integer
 * @property $user_id integer
 * @property $video_id integer
 * @property $location_id integer
 * @property $type string
 * @property $big_download_attempts integer
 * @property $small_download_attempts integer
 *
 */
class LicensedVideo extends Model
{
    use HasFactory;

    const FREE = 'free';
    const PAID = 'paid';
    const ADDITIONAL = 'additional';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'video_id',
        'location_id',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * @param User $user
     * @return mixed
     */
    public static function getIndexLicensedVideos(User $user, $videoId = null, $locationId = null)
    {
        return self::select([
            'licensed_videos.id as video_id',
            'licensed_videos.location_id as location_id',
            'licensed_videos.created_at as created_at',
            DB::raw('GROUP_CONCAT(CONCAT_WS("",operate_locations.address)) as location_name'),
            'gallery_items.title as video_title'
        ])
            ->join('operate_locations', 'location_id', '=', 'operate_locations.id')
            ->join('gallery_items', 'video_id', '=', 'gallery_items.id')
            ->where('licensed_videos.user_id', $user->id)
            ->when($videoId, function ($query, $videoId) {
                $query->where('gallery_items.id', $videoId);
            })
            ->when($locationId, function ($query, $locationId) {
                $query->where('licensed_videos.location_id', $locationId);
            })
            ->groupBy(['licensed_videos.video_id'])
            ->get();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public static function getLicensedVideos(User $user, $videoId = null, $locationId = null)
    {
        return self::select([
            'licensed_videos.id as video_id',
            'operate_locations.name as location_name',
            'licensed_videos.location_id as location_id',
            'licensed_videos.created_at as created_at',
            'gallery_items.title as video_title'
        ])
            ->join('operate_locations', 'location_id', '=', 'operate_locations.id')
            ->join('gallery_items', 'video_id', '=', 'gallery_items.id')
            ->where('licensed_videos.user_id', $user->id)
            ->when($videoId, function ($query, $videoId) {
                $query->where('gallery_items.id', $videoId);
            })
            ->when($locationId, function ($query, $locationId) {
                $query->where('licensed_videos.location_id', $locationId);
            })
            ->get();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public static function getOneLicensedVideo(User $user, $videoId, $locationId = null)
    {
        return self::select([
            'licensed_videos.video_id as video_id',
            'licensed_videos.location_id as location_id',
            'licensed_videos.created_at as created_at',
            'operate_locations.name as location_name',
            'gallery_items.title as video_title'
        ])
            ->join('operate_locations', 'location_id', '=', 'operate_locations.id')
            ->join('gallery_items', 'video_id', '=', 'gallery_items.id')
            ->where('licensed_videos.user_id', $user->id)
            ->where('gallery_items.id', $videoId)
            ->when($locationId, function ($query, $locationId) {
                $query->where('licensed_videos.location_id', $locationId);
            })
            ->first();
    }

    public static function isAlreadyLicensed(User $user, int $video_id)
    {
        return self::where('user_id', $user->id)->where('video_id', $video_id)->first();
    }

    public static function hasLicensedVideoThisMonth(User $user)
    {
        $lastAssignedVideoDate = self::select('created_at')->where('user_id', $user->id)->where('type', self::FREE)->orderBy('created_at', 'DESC')->first();
        if (!$lastAssignedVideoDate) {
            return true;
        }

        $lastVideoDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastAssignedVideoDate->created_at)->addMonth();
        $currentDate = Carbon::now();
        return $currentDate >= $lastVideoDate;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public static function hasFreeLocation(User $user)
    {
//        return self::where('user_id', $user->id)->where('video_id', $user->video_render_parameters['video_id'])->where('type', self::FREE)->first();
        $notFilteredLocations = self::where('user_id', $user->id)->where('video_id', $user->video_render_parameters['video_id'])->where('type', self::FREE)->first();
        if ($notFilteredLocations) {
            $galleryItem = GalleryItem::find($user->video_render_parameters['video_id']);
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
                if(!$prohibited) {
                    $filteredLocations[] = $location;
                }
            }
            if (count($filteredLocations)) {
                $locations = $filteredLocations;
            } else {
                $locations = $notFilteredLocations;
            }

            return $locations;
        }


        return $notFilteredLocations;

    }

    /**
     * @param array $locations
     * @return string
     */
    public function getOperateLocationsNames(array $locations)
    {
        $locationNames = OperateLocation::select(['name'])->whereIn('id', $locations)->get();
        $result = '';
        foreach ($locationNames as $item) {
            $result .= $item . "\n";
        }
        return $result;
    }

    /**
     * @param $locationsFromPost
     * @return array
     */
    public static function getAllowedLocations($locationsFromPost)
    {

        $licensedLocationsIds = LicensedVideo::select('location_id')->distinct('location_id')->get();
        $locationsInDatabase = OperateLocation::whereIn('id', $licensedLocationsIds)->get();

        $excludedLocations = [];

        foreach ($locationsFromPost as $selectedLocation) {
            foreach ($locationsInDatabase as $existingLocation) {
                if ($selectedLocation->id == $existingLocation->id) {
                    $excludedLocations[] = $existingLocation->id;
                    continue;
                }

                if (OperateLocation::calculateDistance($selectedLocation, $existingLocation) < config('app.distance')) {
                    $excludedLocations[] = $existingLocation->id;
                }
            }
        }

        return $excludedLocations;

    }

    public function location()
    {
        return $this->belongsTo(OperateLocation::class, 'location_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(GalleryItem::class);
    }

}
