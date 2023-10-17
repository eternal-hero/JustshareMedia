<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdditionalCoupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdditionalCouponCodeController extends Controller
{
    /**
     * Coupons administrative landing page.
     *
     * @return void
     */
    public function index()
    {
        $coupons = AdditionalCoupon::all();

        return view('admin/coupons/additional/index')->with('coupons', $coupons);
    }

    /**
     * Viewing a single coupon model.
     *
     * @param int @id
     * @return void
     */
    public function coupon($id)
    {
        $coupon = AdditionalCoupon::find($id);

        return view('admin/coupons/additional/coupon')->with('coupon', $coupon);
    }

    /**
     * Display form for adding a new coupon
     *
     * @return view
     */
    public function add()
    {
        return view('admin/coupons/additional/add')->with('plans', \App\Models\SubscriptionPlan::all())->with('terms', \App\Helpers::getOrderTerms());
    }

    /**
     * Attempt to add a new coupon.
     *
     *@param Request $request
     * @return view
     */
    public function post(Request $request)
    {

        $coupon = new AdditionalCoupon();
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->save();

        // Return to the coupons index
        return redirect(route('admin.coupons.additional'))->with('success', "Coupon $coupon->code added successfully");
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
        $coupon = AdditionalCoupon::find($id);
        $coupon->value = $request->value;
        $coupon->code = $request->code;
        $coupon->save();

        // Coupon updated successfully
        return redirect(route('admin.coupons.view.additional', ['id' => $id]))->with('success', "Coupon $coupon->code updated successfully");
    }
}
