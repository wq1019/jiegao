<?php

namespace App\Http\Controllers\Backend\Api\Auth;

use App\Exceptions\ResourceException;
use App\Http\Controllers\ApiController;
use Auth;
use Cache;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lang;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator;

class LoginController extends ApiController
{
    use ThrottlesLogins;

    protected $userName;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    public function captchaSrc()
//    {
//        return ['src' => captcha_src()];
//    }

    public function needVerificationCodeRequest(Request $request)
    {
        return [
            'need' => $this->needVerificationCode($request->ip()),
        ];
    }

    /**
     * 是否需要验证码
     *
     * @return bool
     */
    protected function needVerificationCode($ip)
    {
        $key = $this->getAttemptLoginTimesKey($ip);
        if (!Cache::has($key)) {
            return false;
        }
        $times = Cache::get($key);

        return $times > config('tiny.need_not_verification_code_times', 5);
    }

    protected function getAttemptLoginTimesKey($ip)
    {
        return 'attempt_login_times:'.$ip;
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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

        $ip = $request->ip();
        $this->addAttemptLoginTimes($ip);
        if ($this->needVerificationCode($ip)) {
            // 验证码
            $this->validate($request, [
                'captcha' => 'required|captcha',
            ]);
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
     * 验证登录请求
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin($request)
    {
        $credentials = $this->credentials($request);
        $rules = [
            'user_name' => ['bail', 'required', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email'     => ['bail', 'required', 'email', 'exists:users'],
            'password'  => ['required'],
        ];

        $validator = Validator::make(
            $credentials,
            Arr::only($rules, array_keys($credentials))
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has($this->username())) {
                $messages = $errors->getMessages();
                $messages[$this->loginKey()] = $messages[$this->username()];
                $errors = Arr::except($messages, $this->username());
            }

            throw new ResourceException(null, $errors);
        }
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->loginKey(), 'password');
        if (!isset($credentials[$this->loginKey()])) {
            $credentials[$this->loginKey()] = null;
        }

        return [
            $this->username() => $credentials[$this->loginKey()],
            'password'        => $credentials['password'],
        ];
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginKey()
    {
        return 'account';
    }

    public function username()
    {
        if (!$this->userName) {
            if (false === strpos(request($this->loginKey()), '@')) {
                $this->userName = 'user_name';
            } else {
                $this->userName = 'email';
            }
        }

        return $this->userName;
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw new HttpException(423, Lang::get('auth.throttle', ['seconds' => $seconds]));
    }

    protected function addAttemptLoginTimes($ip)
    {
        $key = $this->getAttemptLoginTimesKey($ip);
        $cacheTime = config('tiny.not_verification_code_time_interval', 60 * 24);
        if (Cache::has($key)) {
            Cache::increment($key);
        } else {
            Cache::put($key, 1, $cacheTime);
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     *
     * @return \App\Support\Response\Response|void
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($this->guard()->user()->isLocked()) {
            $this->logout($request);

            return abort('423', Lang::get('auth.user_locked'));
        }

        return $this->response()->noContent();
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->response()->noContent();
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // 用户名或密码错误
        throw new ResourceException(null, ['password' => Lang::get('auth.password_error')]);
    }
}
