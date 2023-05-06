<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function usersSite(Request $request){
        $users=User::where('type',1)->get();
        $search='';
        if($request->filled('search')){
            $search=$request->input('search');
            $users=User::where('type',1)
                ->where('name','LIKE','%'.$search.'%')
                ->orwhere('email','LIKE','%'.$search.'%')
                ->get();
        }
        
        return view('users',['users'=>$users,'search'=>$search]);
    }

    public function blockUnlock($id){
        $user=User::where('id',$id)->first();
        $user->block=$user->block===0?1:0;
        $user->save();

        return redirect()->route('users');
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