<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\File\User;

class RestrictAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $currentRouteAction = \Route::currentRouteAction();
        $c_a = explode('@', $currentRouteAction);
        if(count($c_a)<2) return $next($request);

        list($controller,$action) = explode('@', $currentRouteAction);

        $cname = substr($controller, strlen('App\\Http\\Controllers\\'));

        $user = Auth::User();
        if(!$user)
        {
            $user_count=User::count();
            if($user_count==0)
            {
                if( $cname=='Auth\\AuthController' &&
                    ($action=='showRegistrationForm' || $action=='register'))
                    return $next($request);
                else
                    return redirect()->action('Auth\AuthController@showRegistrationForm')->with('message','You must create the 1st user(which would be super admin) before any tasks!')->with('message_type','warning');
            }
            else if($cname=='Auth\\AuthController')
            {
                if($action=='showRegistrationForm' || $action=='register')
                {
                    return redirect()->action('Auth\AuthController@showLoginForm')->with('message','Only super admin can create more users!')->with('message_type','warning');
                }
                else if($action=='showLoginForm' || $action=='login')
                    return $next($request);
            }
            else if($cname=='Auth\\PasswordController')
                return $next($request);

            return redirect(action('Auth\AuthController@showLoginForm').'?continue='.\Request::url())->with('message','You must login to visit this page!')->with('message_type','warning');
        } 
        else
        {
            if($user->type===0) return $next($request); //Super Admin!
            if($cname=='PageController' || ($cname=='Auth\\AuthController' && $action=='logout') || ($cname=='HomeController' && ($action=='getIndex' || $action=='getHome')) )
                return $next($request);
        }
        return redirect('/');
    }
}
