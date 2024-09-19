<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo()
    {
        return '/email/verify';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(RegisterRequest $request)
    {
        $this->validator($request->all())->validate();
        $user=$this->create($request->all());

        $user->notify(new CustomVerifyEmail());
        $this->guard()->login($user);

        return redirect('/email/verify');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dodan role prilikom registracije
        return Validator::make($data, [
            'name' => ['required', 'string','regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 
            'regex:/[a-zA-ZčćČĆžšŽŠĐđDždž]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*?&]/',
            'confirmed'],
            'role'=>['required','string','in:user,shelter'],
            'city'=>['required', 'string','regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u','max:255'],
            'address'=>['required',
            'string',
            'max:255',
            'regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\p{N}\s]+$/u'],
            'surname'=>['required', 'string','regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u','max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'city'=>$data['city'],
            'address'=>$data['address'],
            'surname'=>$data['surname'],
        ]);
    }

}
