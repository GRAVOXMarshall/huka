<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Classes\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Modules\Authentication\Http\Classes\Authenticates;

class AuthenticationController extends Controller
{
    use Authenticates;
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('front');
    }

    /**
     * Logout the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //dd(Auth::guard('admins')->getName());
        $sessionKey = Auth::guard('front')->getName();

        // Logout current user by guard
        Auth::guard('front')->logout();

        // Delete single session key (just for this user)
        $request->session()->forget($sessionKey);

        //Auth::guard('admins')->logout();

        //$request->session()->invalidate();

        return redirect('/');
    }


    /**
     * Register user in the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   
        $inputs = $this->validateRegister($request);
        $values = array();
        foreach ($inputs as $key => $value) {
            if ($key != 'password') {
                $values[$key] = $value;
            }else{
                $values[$key] = Hash::make($value);
            }
            
        }

        event(new Registered($user = User::create($values)));

        $this->guard()->login($user);

        return redirect('/');
        
    }

    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRegister(Request $request)
    {
        $inputs = array();
        
        foreach ($request->all() as $key => $value) {
            if ($key != '_token') {
                $inputs[$key] = 'required|string';
            }
        }
        return $request->validate($inputs);
    }

}
