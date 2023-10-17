<?php

namespace App\Models;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;

use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Illuminate\Support\Facades\File;


/**
 * Class GalleryItem
 *
 * @package App\Models
 * @property $id integer
 * @property $title string
 * @property $thumbnail string
 * @property $title_image string
 * @property $public integer
 * @property $shingle_type string
 * @property $title_video string
 * @property $big_video string
 * @property $small_video string
 * @property $created_at string
 * @property $updated_at string
 */
class GalleryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'thumbnail',
        'title_image',
        'public',
        'shingle_type',
        'title_video',
        'big_video',
        'small_video',
        'created_at',
        'updated_at'
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
        'public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     *
     * @return string
     */
    public function galleryUrl(string $entity)
    {
        return Storage::url($this->$entity);
    }

    /**
     * Replace 1 => 'Yes' and 0 => 'No' on the table column Public on admin/index gallery page.
     * @return string
     */
    public function drawPublicColumn()
    {
        return $this->public == 1 ? 'Yes' : 'No';
    }

    public static function getAllShingleTypes()
    {
        return GalleryItem::distinct()->where('public', 0)->get(['shingle_type']);
    }

    public function remove()
    {
        // Delete the thumbnail image
        if ($this->thumbnail) {
            Storage::delete($this->thumbnail);
        }

        if ($this->title_video) {
            Storage::delete($this->title_video);
        }

        if ($this->big_video) {
            Storage::delete($this->big_video);
        }

        if ($this->small_video) {
            Storage::delete($this->small_video);
        }

        if ($this->title_image) {
            Storage::delete($this->title_image);
        }

        // Delete this item
        $this->delete();

        // Successfully deleted the gallery item and thumbnail
        return true;
    }

    public static function processVideoOld(string $entity)
    {
        /**
         * @var $user User
         */

        $user = \Auth::user();
        $video = GalleryItem::find($user->video_render_parameters['video_id']);

        if (!File::exists('public/rendered_video/user_' . $user->id . '/video_' . $video->id)) {
            File::makeDirectory(Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/'), 0777, true, true);
        }

        $ffmpeg = FFMpeg::create();

        $property = $entity . '_video';
        $path = Storage::path($video->$property);
        $finalVideo = $ffmpeg->open($path);
        $videoName = $entity . 'FinalVideo.mp4';
        $template = VideoTemplates::find($user->video_render_parameters['template']);

        $ffprobe = FFProbe::create();
        $kiloBitRate = ($ffprobe
            ->streams($path) // extracts streams informations
            ->videos()                      // filters video streams
            ->first()                       // returns the first video stream
            ->get('bit_rate')) / 1024;   // returns the bit_rate property

        $format = (new X264())->setKiloBitrate($kiloBitRate);

        if ($entity == 'small') {
            $finalVideo
                ->filters()
                ->watermark(Storage::path($template->path), [
                    'position' => 'relative',
                    'top' => 20,
                    'left' => 20,
                ])
                ->watermark(Storage::path($user->video_render_parameters['logo']), [
                    'position' => 'relative',
                    'top' => 20,
                    'left' => 20,
                ]);
        } else {
            $finalVideo
                ->filters()
                ->watermark(Storage::path($user->video_render_parameters['logo']), [
                    'position' => 'absolute',
                    'x' => 20,
                    'y' => 20,
                ]);
        }

        $finalVideo->save($format, Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/' . $videoName));
    }

    /**
     * Just another implementation of processingVideo not used in the main flow
     * @param string $entity
     */
    public static function processVideo(string $entity)
    {
        /**
         *
         * @var $user User
         */
        $user = \Auth::user();
        $video = GalleryItem::find($user->video_render_parameters['video_id']);

        if (!File::exists('public/rendered_video/user_' . $user->id . '/video_' . $video->id)) {
            File::makeDirectory(Storage::path('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/'), 0777, true, true);
        }

        $property = $entity . '_video';
        $videoName = $entity . 'FinalVideo.mp4';
        $template = VideoTemplates::find($user->video_render_parameters['template']);

        $logoImage = Image::load(Storage::path($user->video_render_parameters['logo']));
        $blackBarHeight = 236;
        $logoPosition = [
            'top' => ($blackBarHeight - $logoImage->getHeight()) / 2,
            'left' => 20
        ];

        if($template->type != 'custom') {
            $renderedVideo = \ProtoneMedia\LaravelFFMpeg\Support\FFMpeg::fromDisk('local')
                ->open($video->$property);

            if ($entity == 'small') {
                $renderedVideo = \ProtoneMedia\LaravelFFMpeg\Support\FFMpeg::fromDisk('local')->open($video->$property);
                $renderedVideo->addWatermark(function (WatermarkFactory $watermark) use ($template) {
                    $watermark->fromDisk('local')
                        ->open($template->path)
                        ->left(0)
                        ->top(0);
                });
            } else {
                $renderedVideo = \ProtoneMedia\LaravelFFMpeg\Support\FFMpeg::fromDisk('local')
                    ->open($video->$property)
                    ->addWatermark(function (WatermarkFactory $watermark) use ($user, $logoPosition) {
                    $watermark->fromDisk('local')
                        ->open($user->video_render_parameters['logo'])
                        ->left($logoPosition['left'])
                        ->top($logoPosition['top']);
                });
            }
        } else {
            if($entity != 'small') {
                $renderedVideo = \ProtoneMedia\LaravelFFMpeg\Support\FFMpeg::fromDisk('local')
                    ->open($video->$property)
                    ->addWatermark(function (WatermarkFactory $watermark) use ($user, $logoPosition) {
                        $watermark->fromDisk('local')
                            ->open($user->video_render_parameters['logo'])
                            ->left($logoPosition['left'])
                            ->top($logoPosition['top']);
                    });
            } else {
                $renderedVideo = \ProtoneMedia\LaravelFFMpeg\Support\FFMpeg::fromDisk('local')
                    ->open($video->$property)
                    ->addWatermark(function (WatermarkFactory $watermark) use ($template, $logoPosition) {
                        $watermark->fromDisk('local')
                            ->open($template->path)
                            ->left(0)
                            ->top(0);
                    });
            }
        }

        $kiloBitRate = $renderedVideo->getVideoStream()->get('bit_rate') / 1024;
        $renderedVideo->export()
            ->toDisk('local')
            ->inFormat((new \FFMpeg\Format\Video\X264())->setKiloBitrate($kiloBitRate))
            ->save('public/rendered_video/user_' . $user->id . '/video_' . $video->id . '/' . $videoName);
    }

    public function prohibitedLocations() {
        return $this->hasMany(ProhibitedAddress::class);
    }
}
