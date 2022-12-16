<?php

namespace App\Http\Controllers\Guest;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\usersState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;

class AccountController extends Controller
{
    public function __construct()
    {
        return $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(auth()->user()->state->status==='active'){
                return match(auth()->user()->role->name) {
                    'admin' => to_route('admin.dashboard'),
                    'user' => to_route('user.dashboard'),
                    'client' => to_route('client.dashboard')
                 };
            }else{
                return $this->statusLoginAttemp();
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function statusLoginAttemp(){
        Session::flush();
        Auth::logout();
        return back()->withErrors([
            'email' => 'The email has been Suspended or Ban, Please contact us.',
        ])->onlyInput('email');

    }

    protected function validators(UserRequest $request)
    {
       $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'email_verified_at'=>null,
            'role_id'=>$request->role,
            'password'=> Hash::make($request->password),
            'verification_code'=>null,
            'is_verified'=>0
        ]);
        usersState::create([
            'user_id'=>$user->_id,
            'status'=>"active",
        ]);

        event(new Registered($user));
        Auth::login($user);
        return match(auth()->user()->role->name) {
            'user' => to_route('user.dashboard'),
            'client' => to_route('client.dashboard')
         };
         abort(404);
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return to_route('guest.login');
    }

}
