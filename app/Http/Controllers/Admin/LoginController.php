<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admins')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('back/login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
    	//dd(Auth::guard('admins')->getName());
    	$sessionKey = Auth::guard('admins')->getName();

        // Logout current user by guard
        Auth::guard('admins')->logout();

        // Delete single session key (just for this user)
        $request->session()->forget($sessionKey);

        //Auth::guard('admins')->logout();

        //$request->session()->invalidate();
        

        return redirect()->route('admin.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admins');
    }

   /* protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }*/

    protected function attemptLogin(Request $request)
    {
    	 
    	$admin = Admin::where('email', $request->email)->get();
    	if (isset($admin[0]->is_admin) && $admin[0]->is_admin) {
    		return $this->guard()->attempt(
            	$this->credentials($request), $request->filled('remember')
        	);
    	}else{
    		return redirect()->route('admin.login');
    	}
        
    }
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
}
