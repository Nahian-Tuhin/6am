<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //


    public function register_view()
    {
        return view('register');
    }

  public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:10|unique:users,phone',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);

        return '1';
    }


    public function login_view()
    {
        return view('login');
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['phone' => request('data'), 'password' => request('password')]) ||
        Auth::attempt(['email' => request('data'), 'password' => request('password')]) ||
        Auth::attempt(['name' => request('data'), 'password' => request('password')])){
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return redirect()->route('product.index');
        }

        return back()->withErrors(['message' => 'Wrong credentials']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

}

