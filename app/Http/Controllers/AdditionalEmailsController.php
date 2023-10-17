<?php

namespace App\Http\Controllers;

use App\Models\UserEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditionalEmailsController extends Controller
{
    public function add(Request $request) {
        $request->validate([
            'email'=>'email|required'
        ]);
        $user = Auth::user();
        $additionalEmail = new UserEmails();
        $additionalEmail->user_id = $user->id;
        $additionalEmail->email = $request->email;
        $additionalEmail->save();

        return response()->json($additionalEmail);
    }

    public function deleteEmail(Request $request) {
        $user = Auth::user();
        $additionalEmail = UserEmails::find($request->email);
        if($additionalEmail->user_id == $user->id) {
            $additionalEmail->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

    }
}
