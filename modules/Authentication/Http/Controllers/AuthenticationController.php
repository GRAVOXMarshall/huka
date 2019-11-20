<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Classes\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Modules\Authentication\Authentication;
use Modules\Authentication\Http\Classes\User;
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
        $module = new Authentication();
        $configuration = $module->getConfigValue();
        // Validate request of form 
        $inputs = $this->validateLogin($request, $configuration);

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
        return redirect(Page::getMainPage('front'));
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

        return redirect(Page::getMainPage('front'));
    }


    /**
     * Register user in the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   
        $module = new Authentication();
        $configuration = $module->getConfigValue();
        // Validate request of form 
        $inputs = $this->validateRegister($request, $configuration);
        // Update values of password values 
        $values = $this->encryptPasswordValues($configuration, $inputs);
        // Register user 
        event(new Registered($user = User::create($values)));
        // Login user
        $this->guard()->login($user);

        return redirect(Page::getMainPage('front'));
        
    }

    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRegister(Request $request, $configuration)
    {
        $inputs = [];
        foreach ($configuration->fields as $field) {
            $validator = '';
            $validator.= ($field->login) ? 'required|' : '';
            switch ($field->type) {
                case 'TEXT':
                    $validator.= 'string';
                    break;
                case 'EMAIL':
                    $validator.= 'string|unique:users|max:150';
                    break;
                case 'PASSWORD':
                    $validator.= 'string|max:255';
                    break;
                case 'NUMBER':
                    $validator.= 'numeric';
                    break;
                case 'DATE':
                    $validator.= 'date';
                    break;
            }
            $inputs[$field->name] = $validator;
        }

        return $request->validate($inputs);
    }


    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request, $configuration)
    {
        $inputs = [];
        foreach ($configuration->fields as $field) {
            if ($field->login) {
                $validator = 'required|';
                switch ($field->type) {
                    case 'TEXT':
                    case 'EMAIL':
                    case 'PASSWORD':
                        $validator.= 'string';
                        break;
                    case 'NUMBER':
                        $validator.= 'numeric';
                        break;
                    case 'DATE':
                        $validator.= 'date';
                        break;
                }
                $inputs[$field->name] = $validator;
            }
        }

        return $request->validate($inputs);
    }

    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function encryptPasswordValues($configuration, $inputs)
    {
        foreach ($configuration->fields as $field) {
            if ($field->type == 'PASSWORD') {
                $inputs[$field->name] = Hash::make($inputs[$field->name]);
            }
        }

        return $inputs;
    }

}
