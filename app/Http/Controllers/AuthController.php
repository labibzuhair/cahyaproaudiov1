<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;


class AuthController extends Controller
{
    public function registration()
    {
        return view('layouts/auth/registration');
    }

    public function registration_post(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6',
            'is_role' => 'required',
        ]);

        // Create a new User instance and populate it with validated data
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->is_role = trim($request->is_role);
        $user->remember_token = Str::random(50);
        $user->save();

        // Redirect to login with success message
        return redirect('login')->with('success', 'Registration successful');
    }
    public function login_post(Request $request)
    {
        // dd($request->all());
        $remember = $request->has('remember'); // Mengecek apakah checkbox remember me dicentang

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (Auth::User()->is_role == 'admin') {
                return redirect()->intended('admin/beranda');
            } else if (Auth::User()->is_role == 'owner') {
                return redirect()->intended('owner/beranda');
            } else if (Auth::User()->is_role == 'customer') {
                return redirect()->intended('customer/beranda');
            } else {
                return redirect('login')->with('error', 'Please enter the correct credentials');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter the correct ');
        }
    }


    public function login()
    {
        return view('layouts/auth/login');
    }

    public function forgot()
    {
        return view('layouts/auth/forgot');
    }
    public function forgot_post(Request $request)
    {
        // dd($request->all());
        $count = User::where('email', '=', $request->email)->count();
        if ($count > 0) {
            $user = User::where('email', '=', $request->email)->first();
            $user->remember_token = Str::random(50);
            $user->save();
            Mail::to($user->email)->send(new \App\Mail\ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'password has been rest');
        } else {
            return redirect()->back()->with('error', 'Email not found in the system');
        }

    }
    public function getReset(Request $request, $token)
    {
        // dd($token);
        $user = User::where('remember_token', '=', $token);
        if ($user->count() == 0) {
            abort(403);
        }

        $user = $user->first();
        $data['token'] = $token;

        return view('layouts.auth.reset', $data);
    }
    public function postReset($token, ResetPassword $request)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!$user) {
            abort(403);
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(50);
        $user->save();

        return redirect('login')->with('success', 'successfully password reset');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
