<?php

namespace warehouse\Http\Controllers\Auth;

use warehouse\User;
use warehouse\Http\Controllers\Controller;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->middleware('guest');

    }

    // public function registered(Request $request)
    // {
    //     $this->validator($request->all())->validate();
    //     event(new RegisterController($user = $this->create($request->all())));
    //     // $this->guard()->login($user);
    //     // return $this->registered($request, $user)
    //     //     ? : redirect($this->redirectPath());
    //     return view('auth.register-success');   
    // }

    // public function activating($token)
    // {
    //     $model = User::where('token_register', $token)->where('active', 0)->firstOrFail();
    //     $model->active = true;
    //     $model->save();
    //     return 'akun anda telah aktif silahkan login.';
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \warehouse\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'company_branch_id' => $data['branch'],
            'password' => bcrypt($data['password']),
            'token_register'=>str_random(190)
        ]);
    }
}
