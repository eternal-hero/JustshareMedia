<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Coupon extends Model
{
    use HasFactory;

    protected $dates = ['start_at', 'end_at'];

    /**
     * Check if this coupon is enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled == 1 ? true : false;
    }

    /**
     * Check if this coupon is recurring.
     *
     * @return boolean
     */
    public function isRecurring()
    {
        return $this->recurring ? true : false;
    }

    /**
     * Get array of coupon's values
     *
     * @return array
     */
    public function getValues()
    {
        return json_decode($this->value, true);
    }

    /**
     * Get array of coupon's terms
     *
     * @return array
     */
    public function getTerms()
    {
        $terms = [];
        foreach (json_decode($this->terms, true) as $term) {
            $terms[] = $term;
        }
        return $terms;
    }

    /**
     * Get array of coupon's plans
     *
     * @return \App\Models\SubscriptionPlan[] $plans
     */
    public function getPlans()
    {
        $plans = [];
        foreach (json_decode($this->plans, true) as $id) {
            $plans[] = \App\Models\SubscriptionPlan::find($id);
        }
        return $plans;
    }

    /**
     * Validate if received coupon data is accurate.
     *
     * @param Request $request
     * @return array $data
     */
    public static function validateData(Request $request, $newCoupon = false)
    {
        // Validate input
        $validateRules['type'] = 'required';
        $validateRules['code'] = 'required|min:3|max:32';
        if ($newCoupon) $validateRules['code'] .= '|unique:coupons';
        $request->validate($validateRules);

        // Validate at least one selected plan
        $hasPlan = false;
        foreach (\App\Models\SubscriptionPlan::all() as $plan) {
            if ($request->input("plan_$plan->id")) $hasPlan = true;
        }
        if (! $hasPlan) return [
            'result' => false,
            'message' => 'You must select at least one plan',
            'error_plan' => 'Please select at least one plan'
        ];

        // Validate at least one selected term
        $hasTerm = false;
        $terms = \App\Helpers::getOrderTerms();
        foreach ($terms as $term) {
            if ($request->input("term_$term")) $hasTerm = true;
        }
        if (! $hasTerm) return [
            'result' => false,
            'message' => 'You must select at least one term',
            'error_term' => 'Please select at least one term'
        ];

        // Make sure all terms have values
        $valueError = false;
        foreach ($terms as $term) {
            if ($request->input("term_$term")) {
                if (! $request->input("value_$term")) $valueError = "Term $term does not have a value";
                $value = (float)$request->input("value_$term");
                if ($value < 1) $valueError = "Term $term does not have a valid value.";
            }
        }
        if ($valueError) return [
            'result' => false,
            'message' => $valueError,
            'error_term' => $valueError
        ];

        // Successfully validated
        return [
            'result' => true,
            'message' => "Coupon data verified"
        ];
    }

    /**
     * Create or update a coupon.
     *
     * @param Request $request
     * @param int $coupon
     * @return Coupon $coupon
     */
    public static function createOrUpdate(Request $request, $coupon_id = false)
    {
        // Check if we are working with a new or existing oupon
        if ($coupon_id) {
            $coupon = Coupon::find($coupon_id);
            if (! $coupon) return false;
        } else {
            // Create the new coupon
            $coupon = new \App\Models\Coupon;
        }

        // Set coupon code and type
        $coupon->code = $request->input('code');
        $coupon->type = $request->input('type');

        // Handle plans
        $plans = [];
        foreach (\App\Models\SubscriptionPlan::all() as $plan) {
            if ($request->input("plan_$plan->id")) $plans[] = $plan->id;
        }
        $coupon->plans = json_encode($plans);

        // Load terms and values
        $terms = [];
        $values = [];
        foreach (\App\Helpers::getOrderTerms() as $term) {
            if ($request->input("term_$term")) {
                $terms[] = $term;
                switch ($term) {
                    case 'monthly':
                        $values[0] = $request->input("value_$term");
                        break;
                    case 'yearly':
                        $values[1] = $request->input("value_$term");
                        break;
                    case 'contract':
                        $values[2] = $request->input("value_$term");
                        break;
                }
            }
        }

        // Fix missing values
        if (! isset($values[0])) $values[0] = 0; // monthly
        if (! isset($values[1])) $values[1] = 0; // yearly
        if (! isset($values[2])) $values[2] = 0; // contract

        // Set terms and values
        $coupon->terms = json_encode($terms);
        $coupon->value = json_encode($values);

        // Handle promotion period
        if ($request->input('start_at')) {
            $start_at = \DateTime::createFromFormat('m/d/Y', $request->input('start_at'));
            $start_at->setTime(0, 0, 0);
            $end_at = \DateTime::createFromFormat('m/d/Y', $request->input('end_at'));
            $end_at->setTime(23, 59, 59);

            // Set values
            $coupon->start_at = $start_at;
            $coupon->end_at = $end_at;
        }

        // Handle enabled status
        $coupon->enabled = $request->input('enabled') ? true : false;

        // Handle recurring status
        $coupon->recurring = $request->input('recurring') ? true : false;

        // Save the coupon
        $coupon->save();

        // Return the coupon
        return $coupon;
    }
}
