<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\StudentLessons;
use App\Models\StudentPackages;
use App\Models\HolidaySettings;
use App\Models\StudentLessonsBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();
            if($user->user_type == 'student'){
                if ($user->status == 1  && $this->attemptLogin($request)) {
                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);

                    if(isset($request->referer) && strstr($request->referer, 'startsession')) {
						return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended('list-language-partners');
					} else { 
						return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended('list-language-partners');						
					}
                } else {
                    $this->incrementLoginAttempts($request);
                    return redirect()
                            ->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->withErrors(['active' => 'You must be active to login.']);
                }
            } else if ($user->user_type =='teacher' ) {
                if($user->status == 1 && $this->attemptLogin($request)){
					App::setLocale('en');
                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);
                    return $this->authenticated($request, $this->guard()->user())?: redirect()->intended('teacher/dashboard');

                } else {
                    $this->incrementLoginAttempts($request);
                    return redirect()
                            ->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->withErrors(['active' => 'You must be active to login.']);
                }
            }
			
			else {
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'These credentials do not match our records.']);

            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function showStudentLogin() {
        $holidays = HolidaySettings::find(1);

        if(!empty($holidays)){
            $holidays = $holidays->toArray();
        }

        $today = date('Y-m-d');
        $today=date('Y-m-d', strtotime($today));

        $dateBegin = null;
        $dateEnd   = null;

        $message_en = null;
        $message_ja = null;
        if((!empty($holidays['start_date'])) && ($holidays['end_date'])){
            $from = $holidays['start_date'];
            $to = $holidays['end_date'];

            $dateBegin = date('Y-m-d', strtotime($holidays['holiday_message_display_start_date']));
            $dateEnd = date('Y-m-d', strtotime($holidays['end_date']));

            $message_en = $holidays['message_en'];
            $message_ja = $holidays['message_ja'];
        }
		
        return view('auth.login', compact('today', 'dateBegin','dateEnd','message_en','message_ja'));
    }

    public function showTeacherLogin() {
		App::setLocale('en');
        $ref = 'teacher';
        return view('auth.login', compact('ref'));
    }

    public function teacherLogin(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->user_type =='teacher' ) {
                if($user->status == 1 && $this->attemptLogin($request)){
					App::setLocale('en');
                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);
                    return $this->authenticated($request, $this->guard()->user())?: redirect()->intended('teacher/dashboard');

                } else {
                    $this->incrementLoginAttempts($request);
                    return redirect()
                            ->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->withErrors(['active' => 'You must be active to login.']);
                }
            } else {
                $this->incrementLoginAttempts($request);
                return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors(['active' => 'These credentials do not match our records.']);

            }

        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials() {
        $username = $this->username();
        $credentials = request()->only($username, 'password');
        if (isset($credentials[$username])) {
            $credentials[$username] = strtolower($credentials[$username]);
        }
        return $credentials;
    }

    function authenticated(\Illuminate\Http\Request $request, $user) {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }
}
