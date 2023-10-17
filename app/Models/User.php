<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * Class User
 *
 * @package App\Models
 * a
 * @property $id integer
 * @property $first_name string
 * @property $last_name string
 * @property $company string
 * @property $phone string
 * @property $address string
 * @property $address2 string
 * @property $city string
 * @property $state string
 * @property $zip string
 * @property $colors string
 * @property $video_render_parameters string
 * @property $cardnumber string
 * @property $social_facebook string
 * @property $social_twitter string
 * @property $social_instagram string
 * @property $authorize_customer_id string
 * @property $authorize_customer_address_id string
 * @property $authorize_customer_payment_profile_id string
 *
 * @property $email string
 * @property $email_verified_at string
 * @property $password string
 * @property $is_admin string
 * @property $remember_token string
 * @property $created_at string
 * @property $updated_at string
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'company',
        'phone',
        'address',
        'lat',
        'lng',
        'address2',
        'city',
        'state',
        'zip',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'colors',
        'curdnumber',
        'authorize_customer_id',
        'authorize_customer_address_id',
        'authorize_customer_payment_profile_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'colors' => 'array',
        'video_render_parameters' => 'array'
    ];

    /**
     * Checks if a user has an active subscription.
     *
     * @return boolean
     */
    public function isSubscribed()
    {
        foreach (Subscription::where('user_id', $this->id)->get() as $subscription) {
            if ($subscription->isActive()) {
                return true;
            }
        }
        // No active subscriptions
        return false;
    }

    /**
     * Get this order's subscriptions
     *
     * @return \App\Models\Subscription
     */
    public function getSubscribtions()
    {
        return \App\Models\Subscription::select(
            'subscriptions.id as id',
            'orders.total as total',
            'orders.id as order_id',
            'subscription_plans.name as name',
            'subscriptions.start_at as start_at',
            'subscriptions.status as status',
            'subscriptions.authorize_subscription_id as authorize_subscription_id')->where('subscriptions.user_id', $this->id)
            ->join('subscription_plans', 'subscription_plans.id', '=', 'plan_id')
            ->join('orders', 'orders.id', '=', 'order_id')
            ->first();
    }

    /**
     * Check if this user is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled == 1 ? true : false;
    }

    /**
     * Check if this user is onboarded
     *
     * @return boolean
     */
    public function isOnboarded()
    {
        return $this->onboarded ? true : false;
    }

    /**
     * Check if this user is an admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->is_admin ? true : false;
    }

    /**
     * Return the user's current subscription plan name.
     *
     * @return string $planName
     */
    public function getPlanName()
    {
        foreach (Subscription::where('user_id', $this->id)->get() as $subscription) {
            if ($subscription->isActive()) {
                return $subscription->plan->name;
            }
        }
    }

    /**
     * Check if this user has a pending order.
     *
     * @return boolean
     */
    public function hasPendingOrder()
    {
        foreach (\App\Models\Order::where('user_id', $this->id)->get() as $order) {
            if ($order->status == 'pending') return true;
        }

        // User does not have any pending orders
        return false;
    }

    /**
     * @return Order
     */
    public function activeOrder(): Order
    {
        return \App\Models\Order::where('user_id', $this->id)->where('status', 'active')->first();
    }

    /**
     * Validate user profile data.
     *
     * @param Request $request
     * @param boolean $existingUser
     * @return array $result
     */
    public static function validateData($request, $existingUser = false)
    {
        // Setup initial validation rules
        $validationRules = [
            //'plan' => 'required',
            //'term' => 'required',
            'email' => 'required|email',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'company' => 'required|min:5',
            // Disabled for faster dev: @todo re-enable these
            'address' => 'required|min:5',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip' => 'required|min:5',
            'phone' => 'required|min:10',
            // 'creditcardnumber' => 'required|min:16|max:16',
            // 'creditcardcode' => 'required|min:3',
            // 'creditcardexpirymonth' => 'required|min:2',
            // 'creditcardexpiryyear' => 'required|min:2',
            //'agreement' => 'accepted',
            // 'g-recaptcha-response' => 'required|captcha', // json requests make this token time out, needs some reload ability
        ];

        // New user validation rules
        if (!$existingUser) {
            $validationRules['email'] .= '|unique:users';
            $validationRules['password'] = 'required|string|min:10|confirmed';
            $validationRules['password_confirmation'] = 'required';
        } else {
            // Existing user extra validation
            if ($request->input('password')) {
                $validationRules['password'] = 'required|string|min:10|confirmed';
                $validationRules['password_confirmation'] = 'required';
            }
        }

        // Validate the request
        $request->validate($validationRules);

        // Validation success
        return [
            'result' => true,
            'message' => 'User data validated'
        ];
    }

    /**
     * Create or update a user model
     *
     * @param Request $request
     * @param int $user_id
     * @return \App\Models\User $user
     */
    public static function createOrUpdate($request, $user_id = false)
    {
        // Locate existing user ID
        if ($user_id) {
            $user = self::find($user_id);
            if (!$user) return false;
        } else {
            // Create a new user
            $user = new User();
        }

        // Set the user parameters
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->company = $request->input('company');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->social_facebook = $request->input('social_facebook');
        $user->social_twitter = $request->input('social_twitter');
        $user->social_instagram = $request->input('social_instagram');
        $user->is_admin = $request->input('is_admin') ? 1 : 0;
        $user->onboarded = $request->input('onboarded') ? 1 : 0;
        $user->enabled = $request->input('enabled') ? 1 : 0;
        $user->save();

        // Success, return the user
        return $user;
    }

    /**
     * Add a new order for this user.
     *
     * @param float $total
     * @param int $coupon_id
     * @param int $plan_id
     * @param string $term
     * @return \App\Models\Order $order
     */
    public function newOrder($total = false, $coupon_id = false, $plan_id = false, $term = false)
    {
        $order = new \App\Models\Order();
        $order->user_id = $this->id;
        $order->status = 'draft';
        if ($total) $order->total = $total;
        if ($coupon_id) $order->coupon_id = $coupon_id;
        if ($plan_id) $order->plan_id = $plan_id;
        if ($term) $order->term = $term;
        $order->save();
        return $order;
    }

    public function getNotAttachedOperationalLocations(int $videoId, $locationIds = [])
    {
        $condition = '';
        if(count($locationIds)) {
            $condition = " AND id NOT IN (" . implode(',', $locationIds) . ")";
        }

        return DB::select("SELECT  ol.id        as id,
                                   ol.user_id   as user_id,
                                   ol.name      as location_name,
                                   ol.latitude  as lat,
                                   ol.longitude as lng,
                                   ol.address   as address
                            FROM operate_locations ol
                            WHERE ol.user_id = " . $this->id . "
                              AND ol.id NOT IN (SELECT location_id FROM licensed_videos WHERE user_id = " . $this->id . " AND video_id = " . $videoId . ") " . $condition);
    }

    /**
     * @return mixed
     */
    public function getAllUserLocations()
    {
        return OperateLocation::where('user_id', $this->id)->get();
    }

    /**
     * @return string
     */
    public function getBrandColorsForJs()
    {
        if($this->colors){
            $brandColors = '{';
            foreach ($this->colors as $color){
                $brandColors .= '"' . $color['value'] . '":"' . $color['value'] . '",';
            }
            $brandColors = substr($brandColors, 0, -1);
            $brandColors .= '}';
            return $brandColors;
        }
        return '{}';
    }

    /**
     * @return bool
     */
    public function canEditVideo()
    {
        $subscription = Subscription::where('user_id', $this->id)->where('status', 'active')->first();
        if(!$subscription) {
            return false;
        }
        $now = Carbon::now();
        $created_at = new \DateTime($subscription->created_at);
        $monthsBeforeRenewal = $subscription->end_at->copy()->diffInMonths($now);
        $renewalDate = $subscription->end_at->copy()->subMonths($monthsBeforeRenewal);
        $lastRenewed = $renewalDate->copy()->subMonths(1);

        $lastAssignedVideo = LicensedVideo::select('created_at')->where('user_id', $this->id)->where('type', LicensedVideo::FREE)->orderBy('created_at', 'DESC')->first();
        if(!$lastAssignedVideo) {
            return true;
        }

        return $lastAssignedVideo->created_at->between($lastRenewed, $renewalDate) ? false : true;
    }

    /**
     * Return the full profile for this user.
     *
     * @return array $profile
     */
    public function getProfile()
    {
        $profile = [];
        foreach ($this->getAttributes() as $key => $val) {
            $filter = ['first_name', 'last_name', 'company', 'email', 'phone', 'address', 'address2', 'city', 'state', 'zip', 'social_facebook', 'social_twitter', 'social_instagram'];
            if (in_array($key, $filter)) {
                $profile[$key] = $val;
            }
        }
        return $profile;
    }

    public static function allNonAdminUsers() {
        return self::where('is_admin', 0)->where('enabled', 1)->get();
    }

    public function additionalEmails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserEmails::class);
    }

}


