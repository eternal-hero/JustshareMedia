<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * User relationship
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Subscription plan relationship
     *
     * @return \App\Models\SubscriptionPlan
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Coupon relationship
     *
     * @return \App\Models\Coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get this order's transactions (payments)
     *
     * @return \App\Models\Transaction[]
     */
    public function getTransactions()
    {
        return DB::select("SELECT tr.id                       as id,
                                       ois.type                    as type,
                                       ois.amount                  as amount,
                                       oit.amount                  as tax,
                                       ois.amount + oit.amount - oic.amount     as total,
                                       tr.status                   as status,
                                       /*oic.type                    as coupon_type,*/
                                       oic.amount                  as coupon_amount,
                                       tr.authorize_auth_code      as authorize_auth_code,
                                       tr.authorize_transaction_id as authorize_transaction_id,
                                       tr.created_at               as created_at
                                FROM transactions tr
                                         LEFT JOIN order_items ois on tr.order_id = ois.order_id AND tr.id = ois.transaction_id  AND ois.type IN('subscription', 'location')
                                         LEFT JOIN order_items oit on tr.order_id = oit.order_id AND tr.id = oit.transaction_id  AND oit.type = 'tax'
                                         LEFT JOIN order_items oic on tr.order_id = oic.order_id AND tr.id = oic.transaction_id  AND oic.type = 'coupon'
                                WHERE tr.order_id = " . $this->id . "
                                ORDER BY tr.order_id");
    }

    /**
     * Get this order's subscriptions
     *
     * @return \App\Models\Transaction[]
     */
    public function getSubscribtions()
    {
        return \App\Models\Subscription::where('order_id', $this->id)
            ->join('subscription_plans', 'subscription_plans.id', '=', 'plan_id')
            ->get();
    }

    /**
     * Checks if this order has transactions.
     *
     * @return boolean
     */
    public function hasTransactions()
    {
        return $this->getTransactions() ? true : false;
    }

    /**
     * Checks if this order has transactions.
     *
     * @return boolean
     */
    public function hasSubscriptions()
    {
        return $this->getSubscribtions() ? true : false;
    }

    /**
     * Get the total amount for this order.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set new  total amount for this order.
     *
     * @return float
     */
    public function setTotal( float $amount)
    {
        $this->total = $amount;
        $this->save();
    }

    /**
     * Get this order's line items
     *
     * @return \App\Models\OrderItem[] $items
     */
    public function getItems()
    {
        return \App\Models\OrderItem::where('order_id', $this->id)->get();
    }

    /**
     * Check if this order has a coupon.
     *
     * @return boolean
     */
    public function hasCoupon()
    {
        return $this->coupon ? true : false;
    }

    /**
     * Future handler for tax calculations
     *
     * @param float $price
     * @return float
     */
    public static function calculateTax($price, $state_code)
    {
        if ($state_code != '') {
            $taxRate = TaxRate::getTaxRate($state_code);
            return ($price * $taxRate) / 100;
        }

        return 0; //number_format($price * 0.0625, 2);
    }

    /**
     * Calculate the total of an order using a plan ID, term, and coupon code
     *
     * @param int $planID
     * @param string $term
     * @param string $couponCode
     * @return float $price | string
     */
    public static function calculatePrice($planID, $term, $state_code, $couponCode = false)
    {
        // Check for valid plan
        $plan = \App\Models\SubscriptionPlan::find($planID);
        if (! $plan) return false;

        // Validate plan term and price
        $terms = \App\Helpers::getOrderTerms();
        if (! in_array($term, $terms)) return false;

        // Set price for this term
        $price = $term == 'yearly' ? $plan->$term * 12 : $plan->$term;
        if (! $price || $price <= 0) return false;

        // Calculate tax
        $tax = self::calculateTax($price, $state_code);

        // Set original price array;
        $pricing = [
            'special' => false,
            'tax' => (float) $tax,
            'tax_rate' => number_format(TaxRate::getTaxRate($state_code), 2),
            'original_price' => (float) $price,
            'price' => (float) $price + (float) $tax,
            'original' => $price,
            'coupon' => false,
            'coupon_id' => false,
            'coupon_value' => false,
            'coupon_type' => false
        ];

        // If no coupon, return standard pricing
        if (! $couponCode) return $pricing;

        // Validate coupon
        $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
        if (! $coupon) return $pricing;

        // Verify coupon is enabled
        if (! $coupon->isEnabled()) return $pricing;

        // If coupon has a start date, make sure we are on or after it
        if ($coupon->start_at) {
            $now = new \DateTime();
            if ($now < $coupon->start_at) {
                // Coupon hasn't started yet
                return $pricing;
            }
        }

        // If coupon has an end date, make sure we are before or on it
        if ($coupon->end_at) {
            $now = new \DateTime();
            if ($now > $coupon->end_at) {
                // Coupon is expired
                return $pricing;
            }
        }

        // Check if this coupon covers our plan
        $plans = json_decode($coupon->plans, true);
        if (! in_array($plan->id, $plans)) return $pricing;

        // Check if this coupon covers our term
        $terms = json_decode($coupon->terms, true);
        if (! in_array($term, $terms)) return $pricing;

        // Calculate based on coupon type
        $values = json_decode($coupon->value, true);
        switch ($term) {
            case 'monthly':
                $value = $values[0];
                break;
            case 'yearly':
                $value = $values[1];
                break;
            case 'contract':
                $value = $values[2];
                break;
        }
        switch ($coupon->type) {
            case 'fixed':
                $pricing['price'] = $pricing['original'] - $value;
                break;
            case 'percentage':
                $pricing['price'] = $pricing['original'] - ($pricing['original'] * ($value / 100));
                break;
            default:
                Log::error("Order::calculatePrice() - Invalid Coupon Type: $coupon->type", ['coupon' => $coupon]);
                return false;
        }

        // Check if this coupon is recurring
        if ($coupon->isRecurring()) {
            $pricing['recurring'] = true;
        }

        // Calculate tax
        $tax = self::calculateTax($pricing['price'], $state_code);
        $pricing['original_price'] = (float) $pricing['price'];
        $pricing['price'] += (float) $tax;
        $pricing['tax'] = (float) $tax;

        // Return final special pricing
        $pricing['special'] = true;
        $pricing['coupon'] = $coupon->code;
        $pricing['coupon_id'] = $coupon->id;
        $pricing['coupon_value'] = $coupon->type == 'fixed' ? $value : $pricing['original'] * ($value / 100);
        $pricing['coupon_type'] = $coupon->type;


        return $pricing;
    }

    /**
     * Get the customer friendly description of this coupon
     *
     * @return string $description
     */
    public function getCouponDescription()
    {
        if (! $this->coupon) return false;

        $values = json_decode($this->coupon->value, true);
        switch ($this->term) {
            case 'monthly':
                $value = $values[0];
                break;
            case 'yearly':
                $value = $values[1];
                break;
            case 'contract':
                $value = $values[2];
                break;
        }
        switch ($this->coupon->type) {
            case 'fixed':
                if ($this->coupon->isRecurring()) {
                    return "$$value recurring discount";
                } else {
                    return "$$value one time discount";
                }
                break;
            case 'percentage':
                if ($this->coupon->isRecurring()) {
                    return "$value% recurring discount";
                } else {
                    return "$value% one time discount";
                }
                break;
            default:
                Log::error("Order::getCouponDescription() - Invalid Coupon Type: " . $this->coupon->type, ['coupon' => $this->coupon]);
                return false;
        }
    }

    public function getCouponValue()
    {
        if (! $this->coupon || !$this->coupon->isEnabled()) return 0;

        if ($this->coupon->start_at) {
            $now = new \DateTime();
            if ($now < $this->coupon->start_at) {
                // Coupon hasn't started yet
                return 0;
            }
        }

        // If coupon has an end date, make sure we are before or on it
        if ($this->coupon->end_at) {
            $now = new \DateTime();
            if ($now > $this->coupon->end_at) {
                // Coupon is expired
                return 0;
            }
        }

        $values = json_decode($this->coupon->value, true);
        switch ($this->term) {
            case 'monthly':
                $value = $values[0];
                break;
            case 'yearly':
                $value = $values[1];
                break;
            case 'contract':
                $value = $values[2];
                break;
        }
        return $value;

    }

    /**
     * Add a new line item to this order.
     *
     * @param string $type
     * @param string $name
     * @param array $data
     * @param float $amount
     * @param string $transactionId
     * @return boolean $result
     */
    public function addItem($type, $name, $amount, $transactionId, $data = false)
    {
        $item = new \App\Models\OrderItem();
        $item->order_id = $this->id;
        $item->type = $type;
        $item->name = $name;
        $item->transaction_id = $transactionId;
        if ($data) $item->data = json_encode($data);
        $item->amount = $amount;
        $item->save();
        return true;
    }

    /**
     * Publish this order so it is viewable by customers.
     *
     * @return boolean
     */
    public function publish()
    {
        // Make sure order is a draft
        if ($this->status != 'draft') return false;

        // Publish order
        $this->status = 'pending'; // @todo Use a different status?
        $this->save();
        return true;
    }
}
