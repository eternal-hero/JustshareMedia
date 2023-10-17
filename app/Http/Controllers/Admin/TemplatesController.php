<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\VideoTemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TemplatesController extends Controller
{
    /**
     * Administrative view of current gallery items.
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'items' => \App\Models\VideoTemplates::where('type', null)->groupBy('path')->get()
        ];

        return view('admin/templates/index')->with('data', $data);
    }

    /**
     * Show form for adding a new resource.
     *
     * @return response
     */
    public function add()
    {
        $users = User::allNonAdminUsers();
        $data = [
            'users' => $users
        ];

        return view('admin/templates/add')->with('data', $data);
    }

    /**
     * Show form for editing the resource.
     *
     * @param VideoTemplates $mainTemplate
     * @return view
     */
    public function edit(VideoTemplates $mainTemplate)
    {
        $users_ids = VideoTemplates::where('path', $mainTemplate->path)->pluck('user_id');
        $assignedUsers = User::whereIn('id', $users_ids)->pluck('id')->toArray();
        $allUsers = User::allNonAdminUsers();

        $data = [
            'template' => $mainTemplate,
            'assignedUsers' => $assignedUsers,
            'allUsers' => $allUsers
        ];

        return view('admin/templates/edit')->with('data', $data);
    }

    /**
     * Show the delete form.
     *
     * @param VideoTemplates $mainTemplate
     * @return response
     */
    public function deleteForm(VideoTemplates $mainTemplate)
    {
        return view('admin/templates/delete')->with('mainTemplate', $mainTemplate);
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
            'template' => 'required|image',
            'users' => 'required',
        ], [
            'title_video.required' => 'Title video file is required',
            'template.required' => 'Template file is required',
            'users.required' => 'Template must be assigned to at least one user',
        ]);

        $templatePath = $request->file('template')->store('public/video_templates');

        $allCustomerUsers = User::allNonAdminUsers();
        if(count($request->users) == count($allCustomerUsers)) {
            $item = new VideoTemplates();
            $item->title = $request->input('title');
            $item->path = $templatePath;
            $item->save();
        } else {
            foreach ($request->users as $user) {
                $item = new VideoTemplates();
                $item->title = $request->input('title');
                $item->path = $templatePath;
                $item->user_id = $user;
                $item->save();
            }
        }

        // Redirect to dashboard
        return redirect()->route('admin.templates')->with('itemAdded', true);
    }

    /**
     * Update a gallery item.
     *
     * @param VideoTemplates $mainTemplate
     * @param Request $request
     * @return response
     */
    public function patch(VideoTemplates $mainTemplate, Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'users' => 'required',
        ], [
            'title_video.required' => 'Title video file is required',
            'template.required' => 'Template file is required',
            'users.required' => 'Template must be assigned to at least one user',
        ]);

        if($request->template) {
            $templatePath = $request->file('template')->store('public/video_templates');
        } else {
            $templatePath = $mainTemplate->path;
        }
        $date = $mainTemplate->created_at;
        VideoTemplates::where('path', $mainTemplate->path)->delete();

        $allCustomerUsers = User::allNonAdminUsers();
        if(count($request->users) == count($allCustomerUsers)) {
            $item = new VideoTemplates();
            $item->title = $request->input('title');
            $item->path = $templatePath;
            $item->created_at = $date;
            $item->save();
        } else {
            foreach ($request->users as $user) {
                $item = new VideoTemplates();
                $item->title = $request->input('title');
                $item->path = $templatePath;
                $item->user_id = $user;
                $item->created_at = $date;
                $item->save();
            }
        }

        $newTemplate = VideoTemplates::where('path', $templatePath)->first();

        return redirect()->route('admin.templates.edit', $newTemplate->id)->with('success', true);

    }

    /**
     * Delete the resource.
     *
     * @param VideoTemplates $mainTemplate
     * @param Request $request
     * @return response
     */
    public function delete(VideoTemplates $mainTemplate, Request $request)
    {
        VideoTemplates::where('path', $mainTemplate->path)->delete();

        return redirect()->route('admin.templates')->with('success', 'The template item has been deleted');
    }

    public function getUserList(VideoTemplates $mainTemplate) {
        $users_ids = VideoTemplates::where('path', $mainTemplate->path)->pluck('user_id');
        $assignedUsers = User::whereIn('id', $users_ids)->pluck('email')->toArray();

        return $assignedUsers;
    }

}
