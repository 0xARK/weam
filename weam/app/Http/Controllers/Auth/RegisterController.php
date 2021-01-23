<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $beforeDate = date('Y-m-d', strtotime(date('Y-m-d').' -13 year'));
        $afterDate = date('Y-m-d', strtotime(date('Y-m-d').' -149 year'));

        return Validator::make($data, [
            'username' => ['required', 'string', 'between:3,25', 'unique:users', 'regex:/^[_a-zA-Z0-9]{3,25}$/'],
            'email' => ['required', 'string', 'email', 'max:75', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/'],
            'birthdate' => ['required', 'date', 'date_format:m-d-Y', 'size:10', "before:$beforeDate", "after:$afterDate"]
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
            'username' => $data['username'],
            'email' => $data['email'],
            'birthdate' => $data['birthdate'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
