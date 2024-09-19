<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'shelter') {
                return redirect('shelter/showdogs');
            } else if ($user->role == 'user') {
                return redirect('user/showdogs');
            } else if ($user->role == 'admin') {
                return redirect('admin/dashboard');
            }
        }
        return view('auth.login');
    }
}
