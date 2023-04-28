<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function myProfile(){
        return view('myProfile');
    }

    public function updateUser(Request $request){
        $user=User::where('id',Auth::user()->id)->first();
        $data=$request->only(['name','email','password']);
        
        $user->name=$request->filled('name')?$data['name']:$user->name;
        $user->email=$request->filled('email')?$data['email']:$user->name;
        $user->password=$request->filled('password')?Hash::make($data['password']):$user->password;
        $user->save();

        return redirect()->route('myProfile');
    }
}