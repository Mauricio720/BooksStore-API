<?php

namespace App\Http\Controllers;

use App\Models\Address;
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
        $user=User::where('id',Auth::guard('api')->user()->id)->first();
        
        $user->name=$request->filled('name')?$request->input('name'):$user->name;
        $user->email=$request->filled('email')?$request->input('email'):$user->email;
        $user->password=$request->filled('password')
            ?
            Hash::make($request->input('password'))
            :
            $user->password;
        $user->save();

        return redirect()->route('myProfile');
    }
}