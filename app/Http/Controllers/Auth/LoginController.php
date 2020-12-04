<?php
namespace warehouse\Http\Controllers\Auth;

use Illuminate\Http\Request;
use warehouse\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
 
    public function login(Request $request)
    {
        $this->validateLogin($request);
    
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
 
            return $this->sendLockoutResponse($request);
        }
 
        if ($this->attemptLogin($request)) {
            return response()->json([$this->sendLoginResponse($request)]);

        }
 
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
  
    // public function logout(Request $request)
    // {
    //     $this->guard()->logout();
 
    //     $request->session()->invalidate();
 
    //     return redirect('/');
    // }
 
 
 
    protected function attemptLogin( Request $request ) :bool
    {
        $credentials = array_merge( $this->credentials($request));
        
        if( $this->guard()->attempt($credentials, $request->filled('remember'), ['delete_at' !== null]) ) {
            return true;
        }
 
        return false;
    }
 
 
 
    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'password', 'active');
    // }

    // public function login(Request $request)
    // {
    //     $user = User::where('email', $request->input('email'))->first();

    //     if (auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

    //         $new_sessid = \Session::getId();

    //         if($user->session_id != '') {
    //             $last_session = \Session::getHandler()->read($user->session_id); 

    //             if ($last_session) {
    //                 if (\Session::getHandler()->destroy($user->session_id)) {
    //                     swal()->toast()->autoclose(4000)->message("Information","you have expired session",'warning'); 
    //                 }
    //             }
    //         }

    //         User::where('id', $user->id)->update(
    //             ['session_id' => $new_sessid]);
            
    //         $user = auth()->guard('web')->user();
            
    //         return redirect($this->redirectTo);
    //     }   
    //     swal()->toast()->autoclose(3500)->message("Information","Email & password anda tidak terdaftar.",'info'); 
    //     return back();

    // }

    // public function logout(Request $request)
    // {
    //     \Session::forget($request->User()->name);
    //     Auth::logout();
    //     swal()->toast()->autoclose(4500)->message("Information","You have successfully log out",'info'); 

    //     return redirect()->to('/login');

    // }

}
