<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Coupons administrative landing page.
     *
     * @return void
     */
    public function index()
    {
        $coupons = \App\Models\Coupon::all();
        return view('admin/coupons/index')->with('coupons', $coupons);
    }

    /**
     * Viewing a single coupon model.
     *
     * @param int @id
     * @return void
     */
    public function coupon($id)
    {
        $coupon = \App\Models\Coupon::find($id);
        if (! $coupon) return redirect('/admin/coupons')->with('error', 'Invalid Coupon');
        return view('admin/coupons/coupon')->with('coupon', $coupon)->with('plans', \App\Models\SubscriptionPlan::all())->with('terms', \App\Helpers::getOrderTerms());
    }

    /**
     * Display form for adding a new coupon
     *
     * @return view
     */
    public function add()
    {
        return view('admin/coupons/add')->with('plans', \App\Models\SubscriptionPlan::all())->with('terms', \App\Helpers::getOrderTerms());
    }

    /**
     * Attempt to add a new coupon.
     *
     *@param Request $request
     * @return view
     */
    public function post(Request $request)
    {
        // Validate coupon data
        $data = \App\Models\Coupon::validateData($request, true);
        if (! $data['result']) return back()->withinput()->with('error', $data['message']);

        // Create the new coupon
        $coupon = \App\Models\Coupon::createOrUpdate($request);
        if (! $coupon) return back()->withInput()->with('error', 'Coupon creation failed, internal error');

        // Return to the coupons index
        return redirect(route('admin.coupons'))->with('success', "Coupon $coupon->code added successfully");
    }

    /**
     * Update an existing coupon
     *
     * @param Request $request
     * @param int $id
     * @return view
     */
    public function patch(Request $request, $id)
    {
        // Validate coupon data
        $data = \App\Models\Coupon::validateData($request);
        if (! $data['result']) return back()->withInput()->with('error', $data['message']);

        // Save the coupon
        $coupon = \App\Models\Coupon::createOrUpdate($request, $id);
        if (! $coupon) return back()->withInput()->with('error', 'Coupon save failed, internal error');

        // Coupon updated successfully
        return redirect(route('admin.coupons.view', ['id' => $id]))->with('success', "Coupon $coupon->code updated successfully");
    }
}
