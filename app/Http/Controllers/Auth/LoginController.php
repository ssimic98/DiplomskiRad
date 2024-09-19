<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
    protected function redirectTo()
    {  
        $role=Auth::user()->role;

        switch($role)
        {
            case 'admin':
                return '/admin/dashboard';
            case 'shelter':
                return '/shelter/showdogs';
            case 'user':
                return '/user/showdogs';
            default:
                return '/login';
        }
    }
     
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $credentials=$this->credentials($request);
        $remember=$request->has('remember');
        if (Auth::attempt($credentials,$remember)) {
            $user = Auth::user();
            
            if ($user->hasVerifiedEmail()) {
                return redirect()->intended($this->redirectTo());
            }

            return redirect('/email/verify')->with('message', 'Molim Vas da verificirate svoj korisnički račun.');
        }

        return $this->sendFailedLoginResponse($request);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
