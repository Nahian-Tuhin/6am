<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];
        if (auth()->user()->isAdmin()){
            $users = User::paginate(10);
        }
         return view('user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->isAdmin() && $user->id != auth()->user()->id) {
            $user->update([
                'role' => $request->role
            ]);
            return redirect()->route('user.index')->with('success', 'User role updated successfully');
        }
        return redirect()->route('user.index')->with('error', 'User role not updated');

    }
}
