<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
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

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        // $data = [
        //     'email' => $request->email,
        //     'password' => $request->password
        // ];

        // if (auth()->attempt($data))

        if (Auth::attempt(['phone' => request('phone'), 'password' => request('password')]) ||
            Auth::attempt(['email' => request('email'), 'password' => request('password')]) ||
            Auth::attempt(['name' => request('name'), 'password' => request('password')])) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
