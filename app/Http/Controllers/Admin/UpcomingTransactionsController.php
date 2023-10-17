<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpcomingTransactionsController extends Controller
{
    public function index() {
        $now = Carbon::now();
        $data = [
            'items' => Subscription::whereDate('end_at', '>=', $now)
                ->where('should_cancel_at', '=', null)
                ->where('status', '!=', Subscription::STATUS_CANCELED)->orderBy('end_at', 'asc')->get()
        ];

        return view('admin/upcoming-transactions/index')->with('data', $data);
    }

    public function changePrice(Subscription $subscription) {
        return view('admin/upcoming-transactions/change-price')->with(compact('subscription'));
    }

    public function doChangePrice(Request $request) {
        $subscription = Subscription::find($request->subscription);
        $subscription->custom_price = $request->price;
        $subscription->save();

        return $request->redirect ? redirect($request->redirect) : redirect()->route('upcoming-transactions');
    }
}
