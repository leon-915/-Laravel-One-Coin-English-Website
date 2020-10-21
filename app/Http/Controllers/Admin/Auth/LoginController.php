<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
		App::setLocale('en');
    }

    public function showLoginForm(\Illuminate\Http\Request $request) {
		$redirect_to = request()->get('redirect_to');
        return view('admin.auth.login', ['url' => 'admin', 'redirect_to' => $redirect_to]);
    }

    protected function credentials() {
        $username = $this->username();
        $credentials = request()->only($username, 'password');
        if (isset($credentials[$username])) {
            $credentials[$username] = strtolower($credentials[$username]);
        }
        return $credentials;
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->status == 1 && $this->attemptLogin($request)) {
				App::setLocale('en');
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be active to login.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function adminLogin(Request $request) {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
			App::setLocale('en');
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Your email or password is incorrect')->withInput();
        }
    }

    public function logout(Request $request)
    {
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
	
	// check if authenticated, then redirect to dashboard
	protected function authenticated(Request $request, $user)
	{		
		if (Auth::guard('admin')->check()) {
			if(isset($request->referer)){
				return redirect()->to($request->referer);
			}else {
				return redirect('/admin/dashboard/');
			}
		} else if($user->role == 'sub_admin') {
			return redirect('/admin/lesson-reports/admin-lessons-report');
		} 
		return redirect('/admin/dashboard');
	}
}
