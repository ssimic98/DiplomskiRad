<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomVerifyEmail;
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails, RedirectsUsers;

    /**
     * Where to redirect users after verification.
     *
     * @return string
     */
    protected function redirectTo()
    {  
        $role=Auth::user()->role;

        switch($role)
        {
            case 'admin':
                return 'admin/health-statuses';
            case 'shelter':
                return 'shelter/showdogs';
            case 'user':
                return 'user/showdogs';
            default:
                return 'home';
        }
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo())
            : view('auth.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        //Privremena prijava korisnika
        Auth::loginUsingId($request->route('id'));

        //Ispuni zahtjev email verifikacije
        $request->fulfill();
        //Odjavi korisnika
        Auth::logout();

        return redirect('/login')->with('message', 'Vaša email adresa je verificirana. Prijavite se.');
    }
    public function resend(Request $request)
    {
        //Dohvati usera koji traži zahtjev
        $user = $request->user();
        //Pošalji mail
        $user->notify(new CustomVerifyEmail());

        return back()->with('message', 'Nova verifikacijska poveznica je poslana na Vašu email adresu.');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
