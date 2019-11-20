<?php

namespace Modules\Authentication\Http\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;
use Modules\Authentication\Authentication;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Validation\ValidationException;

trait Authenticates
{
    use RedirectsUsers, ThrottlesLogins;

       /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $inputs = array();
        
        foreach ($request->all() as $key => $value) {
            if ($key != '_token') {
                $inputs[$key] = 'required|string';
            }
        }
        $request->validate($inputs);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $module = new Authentication();
        $configuration = $module->getConfigValue();
        $inputs = array();
        foreach ($configuration->fields as $field) {
            if ($field->login) {
                array_push($inputs, $field->name);
            }
        }

        return $this->guard()->attempt(
            $this->credentials($request, $inputs), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request, $inputs)
    {
        return $request->only($inputs);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $module = new Authentication();
        $configuration = $module->getConfigValue();
        foreach ($configuration->fields as $field) {
            if ($field->type == 'EMAIL') {
                return $field->name;
            }
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

}
