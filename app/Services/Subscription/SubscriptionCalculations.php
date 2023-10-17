<?php


namespace App\Services\Subscription;


use App\Models\Order;
use Illuminate\Support\Facades\Log;

class SubscriptionCalculations
{
    public static function getPriceHtml($subscription) {
        $html = '';
        $fmt = new \NumberFormatter('us_US', \NumberFormatter::CURRENCY);
        if ($subscription->custom_price) {
            $tax = \App\Models\Order::calculateTax($subscription->custom_price, $subscription->user->state);
            $html .= 'Plan:' . $fmt->formatCurrency($subscription->custom_price, 'USD');
            $html .= '<br> Tax:' . $fmt->formatCurrency($tax, 'USD');
            $html .= '<br> <b>Total</b>:' . $fmt->formatCurrency($subscription->custom_price + $tax, 'USD');
        } else {
            $couponCode = false;
            if ($subscription->order->coupon_id) {
                $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
                if ($coupon) {
                    $couponCode = $coupon->code;
                }
            }
            $now = \Carbon\Carbon::now();
            $term = $subscription->term;
            $diffDays = $subscription->term === 'yearly' ? 365 - 30 : 30;
            if ($now->diffInDays($subscription->end_at) < $diffDays && $subscription->switch_to) {
                $term = $subscription->switch_to;
            }
            $price = \App\Models\Order::calculatePrice($subscription->plan_id, $term, $subscription->user->state, $couponCode);
            $html .= 'Plan:' . $fmt->formatCurrency($price['original'], 'USD');
            $html .= '<br> Discount:' . $fmt->formatCurrency($price['coupon_value'], 'USD');
            $html .= '<br> Tax:' . $fmt->formatCurrency($price['tax'], 'USD');
            $html .= '<br> <b>Total</b>:' . $fmt->formatCurrency($price['price'], 'USD');
        }

        return $html;
    }

    public static function calculateTotal($subscription) {
        if ($subscription->custom_price) {
            $tax = \App\Models\Order::calculateTax($subscription->custom_price, $subscription->user->state);

            return $subscription->custom_price + $tax;
        } else {
            $couponCode = false;
            if ($subscription->order->coupon_id) {
                $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
                if ($coupon) {
                    $couponCode = $coupon->code;
                }
            }
            $term = $subscription->term;
            $price = \App\Models\Order::calculatePrice($subscription->plan_id, $term, $subscription->user->state, $couponCode);

            return $price['price'];
        }
    }


    public static function calculateGross($subscription) {
        if ($subscription->custom_price) {

            return $subscription->custom_price;
        } else {
            $term = $subscription->term;
            $price = \App\Models\Order::calculatePrice($subscription->plan_id, $term, $subscription->user->state);

            return $price['original_price'];
        }
    }

    public static function calculateTax($subscription) {
        if ($subscription->custom_price) {
            $tax = \App\Models\Order::calculateTax($subscription->custom_price, $subscription->user->state);

            return $tax;
        } else {
            $couponCode = false;
            if ($subscription->order->coupon_id) {
                $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
                if ($coupon) {
                    $couponCode = $coupon->code;
                }
            }
            $term = $subscription->term;
            $price = \App\Models\Order::calculatePrice($subscription->plan_id, $term, $subscription->user->state, $couponCode);

            return $price['tax'];
        }
    }

    public static function calculateNetTax($subscription) {
        if ($subscription->custom_price) {
            return Order::calculateTax($subscription->custom_price, $subscription->user->state);
        } else {
            $net = self::calculateTotal($subscription);

            return Order::calculateTax($net, $subscription->user->state);
        }
    }

    public static function couponCode($subscription) {
        $couponCode = false;
        if ($subscription->order->coupon_id) {
            $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
            if ($coupon) {
                $couponCode = $coupon->code;
            }
        }
        return $couponCode;
    }

    public static function discountAmount($subscription) {
        return $subscription->order->getCouponDescription();
    }

    public static function couponCodeEndsAt($subscription) {
        if($subscription->order->coupon) {
            if($subscription->order->coupon->isEnabled()) {
                if($subscription->order->coupon->recurring) {
                    return 'Recurring';
                } else {
                    return $subscription->order->coupon->end_at;
                }
            } else {
                return '';
            }
        }
    }
}
