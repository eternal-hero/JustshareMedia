<?php


namespace App\Http\Middleware;

use App\Models\OperateLocation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FullProfile
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed |
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();
        if(!$user) {
            abort(401, 'Unauthorized');
        }

        $operateLocations = OperateLocation::where('user_id', $user->id)->get();
        $fname = $user->first_name;
        $lname = $user->last_name;
        $company = $user->company;
        $phone = $user->phone;
        $address = $user->address;
        $city = $user->city;
        $hasOperateLocation = count($operateLocations) ? true : false;

        if($fname == '' || $lname == '' || $company == '' || $phone == '' || $address == '' || $city == '' || !$hasOperateLocation) {
            return redirect()->route('dashboard.profile');
        }

        // Handle request
        return $next($request);
    }
}
