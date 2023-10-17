<?php


namespace App\Helpers;


use App\Models\LicensedVideo;
use App\Models\OperateLocation;

class LicensedVideosHoldPeriod
{
    static function excludedVideosForLocations($requestedLocations) : array {
        $licensedVideos = LicensedVideo::all();
        $excludedGalleryItems = [];
        foreach ($licensedVideos as $licensedVideo) {
            // exclude if it's licensed in a range, but not longer then 6 months
            foreach ($requestedLocations as $requestedLocation) {
                if(
                    (
                        OperateLocation::calculateDistance($licensedVideo->location, $requestedLocation) < config('app.distance') &&
                        \Carbon\Carbon::now()->subMonths(config('app.license_hold_period')) < $licensedVideo->created_at
                    ) ||
                    $licensedVideo->location->id == $requestedLocation->id
                ) {
                    $excludedGalleryItems[] = $licensedVideo->video_id;
                }
            }
        }

        return $excludedGalleryItems;
    }
}
