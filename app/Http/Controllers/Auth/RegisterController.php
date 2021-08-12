<?php

namespace App\Http\Controllers\Auth;

use App\Education;
use App\User;
use App\Providers\StrRandom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = 'user/profile/create';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $strRandomProvider = new StrRandom();
        $string            = $strRandomProvider->generateStrRandom();
        
        return User::create([
            'code' => $string,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function nik(Request $request)
    {
        return User::where('nik', $request->nik)->count() > 0 ? 'Unavailable' : 'Available';
    }

    public function check(Request $request)
    {
        return User::where('email', $request->email)->count() > 0 ? 'Unavailable' : 'Available';
    }

    public function jobs()
    {
        return Job::select('id','name')->orderBy('name','ASC')->get();
    }

    public function educations()
    {
        return Education::select('id','name')->orderBy('id','ASC')->get();
    }
}
