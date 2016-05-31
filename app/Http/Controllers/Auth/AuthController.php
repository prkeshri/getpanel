<?php

namespace App\Http\Controllers\Auth;

use App\Models\File\User;
use App\Models\File\UserGroup;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout' , 'showRegistrationForm','register']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('unique_file', function($attribute, $value, $parameters, $validator) use($data) {
            return User::find(md5($data['email'])) ? false:true;
        });

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique_file:user',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function authenticated($request,$user)
    {
        $continue = \Input::get('continue');
        if($continue) return \Redirect::away($continue);
        else return redirect()->intended($this->redirectPath());
    }     
       /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());
        if(!\Auth::user()) 
        {
            \Auth::guard($this->getGuard())->login($this->create($request->all()));
            return redirect($this->redirectPath());
        }
        else
            return redirect()->action('Auth\UserController@getIndex')->with('message_type','success')->with('message','Successfully created! Edit them to add to groups!');
    } 
}
