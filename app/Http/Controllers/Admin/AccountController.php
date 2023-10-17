<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Account list page.
     *
     * @return view
     */
    public function index()
    {
        return view('admin/accounts/index')->with('accounts', \App\Models\User::all());
    }

    /**
     * Show the user add form
     *
     * @return view
     */
    public function add()
    {
        return view('admin/accounts/add');
    }

    /**
     * Add a new user to the system.
     *
     * @param Request $request
     * @return view
     */
    public function post(Request $request)
    {
        // Validate data
        $data = \App\Models\User::validateData($request);
        if (! $data['result']) return back()->withInput('error', $data['message']);

        // Create user
        $user = \App\Models\User::createOrUpdate($request);
        if (! $user) return back()->withInput('error', 'User creation failed, internal error');

        $this->createSubscriptions($user);

        // User created succesfully
        return redirect(route('admin.accounts'))->with('success', "User $user->email created successfully");
    }

    /**
     * View single account.
     *
     * @param int $id
     * @return view
     */
    public function account($id)
    {
        $user = \App\Models\User::find($id);
        if (! $user) return redirect('/admin/accounts')->with('error', 'Invalid Account');
        return view('admin/accounts/account')->with('user', $user);
    }

    /**
     * Update an existing user ID.
     *
     * @param Request $request
     * @param int $id
     * @return view
     */
    public function patch(Request $request, $id)
    {
        // Validate data
        $data = \App\Models\User::validateData($request, true);
        if (! $data['result']) return back()->withInput('error', $data['message']);

        // Create user
        $user = \App\Models\User::createOrUpdate($request, $id);
        if (! $user) return back()->withInput('error', 'User creation failed, internal error');

        $this->createSubscriptions($user);


        // User created succesfully
        return redirect(route('admin.accounts.view', ['id' => $id]))->with('success', "User updated successfully");
    }

    //hot-fix undefined Subscription if create user from admin panel
    public function createSubscriptions($user){

        if ($user->isAdmin()){
            if (!($user->lat && $user->lng))
                $user->update(['lat'=>0,'lng'=>0]);
            if (!$user->cardnumber){
                $user->update(['cardnumber'=>'4242424242424242']);
            }
            try {
                if (!$user->getSubscribtions()){
                    $plan = SubscriptionPlan::query()->first();

                    $order = new Order();
                    $order->user_id = $user->id;
                    $order->plan_id = $plan->id;
                    $order->term = 'contract';
                    $order->status = 'active';
                    $order->total = 0;
                    $order->save();

                    Subscription::query()->create([
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'plan_id' => $plan->id,
                        'term' => 'contract',
                        'status' => 'active',
                        'start_at' => Carbon::now(),
                        'end_at' =>Carbon::now()->addYears(25),
                        'authorize_subscription_id' =>'internal',
                        'custom_price'=> 0
                    ]);
                }
            }catch (\Exception$exception){

            }
            try {
                if (!$user->getSubscriptions()){
                    $plan = SubscriptionPlan::query()->first();

                    $order = new Order();
                    $order->user_id = $user->id;
                    $order->plan_id = $plan->id;
                    $order->term = 'contract';
                    $order->status = 'active';
                    $order->total = 0;
                    $order->save();

                    Subscription::query()->create([
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'plan_id' => $plan->id,
                        'term' => 'contract',
                        'status' => 'active',
                        'start_at' => Carbon::now(),
                        'end_at' =>Carbon::now()->addYears(25),
                        'authorize_subscription_id' =>'internal',
                        'custom_price'=> 0
                    ]);
                }
            }catch (\Exception$exception){

            }



        }
    }
}
