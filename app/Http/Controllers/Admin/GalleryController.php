<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProhibitedAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\GalleryItem;
class GalleryController extends Controller
{
    /**
     * Administrative view of current gallery items.
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'items' => \App\Models\GalleryItem::all()
        ];
        return view('admin/gallery/index')->with('data', $data);
    }

    /**
     * Show form for adding a new resource.
     *
     * @return response
     */
    public function add()
    {
        return view('admin/gallery/add') ;
    }

    /**
     * Show form for editing the resource.
     *
     * @param \App\Models\GalleryItem $item
     * @return view
     */
    public function edit(\App\Models\GalleryItem $item)
    {
        return view('admin/gallery/edit')->with('item', $item);
    }

    /**
     * Show the delete form.
     *
     * @param \App\Models\GalleryItem $item
     * @return response
     */
    public function deleteForm(\App\Models\GalleryItem $item)
    {
        return view('admin/gallery/delete')->with('item', $item);
    }

    /**
     * Add a new gallery item.
     *
     * @param Request $request
     * @return response
     */
    public function post(Request $request)
    {
        // General validation
        $request->validate([
            'title' => 'required|max:50',
            'shingle_type' => 'required|max:255',
            'title_video' => 'required|mimes:mp4',
            'big_video' => 'required|mimes:mp4',
            'small_video' => 'required|mimes:mp4',
            'thumbnail' => 'required|image',
            'title_image' => 'required|image',
        ], [
            'title_video.required' => 'Title video file is required',
            'big_video.required' => 'Video file 16x9 is required',
            'small_video.required' => 'Video file 1x1 is required',
            'thumbnail.required' => 'Thumbnail file is required',
            'title_image.required' => 'Title Image file is required',
        ]);

        // Store the thumbnail
        $title_video = $request->file('title_video')->store('public/gallery_title_videos');
        $big_video = $request->file('big_video')->store('public/gallery_big_videos');
        $small_video = $request->file('small_video')->store('public/gallery_small_videos');
        $path_thimbnail = $request->file('thumbnail')->store('public/gallery_thumbnails');
        $title_image = $request->file('title_image')->store('public/gallery_title_images');

        // Create a new gallery item
        $item = new \App\Models\GalleryItem();
        $item->title = $request->input('title');
        $item->shingle_type = $request->input('shingle_type');
        $item->title_video = $title_video;
        $item->big_video = $big_video;
        $item->small_video = $small_video;
        $item->thumbnail = $path_thimbnail;
        $item->title_image = $title_image;
        $item->public = $request->input('public') ? true : false;
        $item->save();

        $latitudes = $request->prohibited['lat'];
        $longitudes = $request->prohibited['lng'];
        foreach ($request->prohibitedLocations as $key => $prohibitedLocation) {
            $prohibitedAddress = new ProhibitedAddress();
            $prohibitedAddress->gallery_item_id = $item->id;
            $prohibitedAddress->lat = $latitudes[$key];
            $prohibitedAddress->lng = $longitudes[$key];
            $prohibitedAddress->name = $prohibitedLocation;
            $prohibitedAddress->save();
        }

        // Redirect to dashboard
        return redirect()->route('admin.gallery')->with('itemAdded', true);
    }

    /**
     * Update a gallery item.
     *
     * @param GalleryItem $item
     * @param Request $request
     * @return response
     */
    public function patch(GalleryItem $item, Request $request)
    {
        // Validate general parameters
        $request->validate([
            'title' => 'required|max:50',
            'shingle_type' => 'required|max:255',
            'title_video' => 'mimes:mp4',
            'big_video' => 'mimes:mp4',
            'small_video' => 'mimes:mp4',
            'thumbnail' => 'image',
            'title_image' => 'image',
        ]);

        $this->replaceFiles($request, 'thumbnail', $item);
        $this->replaceFiles($request, 'title_video', $item);
        $this->replaceFiles($request, 'big_video', $item);
        $this->replaceFiles($request, 'small_video', $item);
        $this->replaceFiles($request, 'title_image', $item);

        // Update the item parameters
        $item->title = $request->input('title');
        $item->shingle_type = $request->input('shingle_type');
        $item->public = $request->input('public') ? true : false;
        $item->save();

        $item->prohibitedLocations()->delete();

        if($request->prohibitedLocations) {
            $latitudes = $request->prohibited['lat'];
            $longitudes = $request->prohibited['lng'];
            foreach ($request->prohibitedLocations as $key => $prohibitedLocation) {
                if($latitudes[$key] && $longitudes[$key]) {
                    $prohibitedAddress = new ProhibitedAddress();
                    $prohibitedAddress->gallery_item_id = $item->id;
                    $prohibitedAddress->lat = $latitudes[$key];
                    $prohibitedAddress->lng = $longitudes[$key];
                    $prohibitedAddress->name = $prohibitedLocation;
                    $prohibitedAddress->save();
                }
            }
        }


        // Redirect back to the edit page
        return redirect()->route('admin.gallery.edit', ['item' => $item])->with('success', true);
    }

    /**
     * Delete the resource.
     *
     * @param \App\Models\GalleryItem $item
     * @param Request $request
     * @return response
     */
    public function delete(GalleryItem $item, Request $request)
    {
        $item->remove();
        return redirect()->route('admin.gallery')->with('success', 'The gallery item has been deleted');
    }

    /**
     * replaces files related to the gallery item if the user uploaded new ones
     * @param Request $request
     * @param string $filename
     * @param GalleryItem $item
     * @return GalleryItem
     */
    public function replaceFiles(Request $request, string $filename, GalleryItem $item)
    {
        if ($request->hasFile($filename)) {
            // Validate the image
            $request->validate([
                $filename => 'required'
            ]);
            // Delete the old thumbnail if one exists
            if ($item->$filename) {
                Storage::delete($item->$filename);
            }
            $path = $request->file($filename)->store('public/gallery_' . $filename . 's');
            $item->$filename = $path;
        }

        return $item;
    }
}
