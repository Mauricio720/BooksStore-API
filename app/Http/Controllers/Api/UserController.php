<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

     /**
     * @OA\PUT(
     *      path="/user",
     *      summary="ATUALIZAÇÃO USUÁRIO",
     *      description="Rota para atualizar do usuário",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      tags={"Usuários"},
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    
    public function update(UserRequest $request){
        $user=User::where('id',Auth::guard('api')->user()->id)->with('address')->first();
     
        $user->name=$request->filled('name')?$request->input('name'):$user->name;
        $user->email=$request->filled('email')?$request->input('email'):$user->email;
        $user->password=$request->filled('password')
            ?
            Hash::make($request->input('password'))
            :
            $user->password;
        $user->save();

        $address=Address::where('users_id',$user->id)->first();
        $address->street=$request->filled('street')?$request->input('street'):$address->street;
        $address->number=$request->filled('number')?$request->input('number'):$address->number;
        $address->neighborhood=$request->filled('number')?$request->input('neighborhood'):$address->neighborhood;
        $address->city=$request->filled('city')?$request->input('city'):$address->city;
        $address->cep=$request->filled('cep')?$request->input('cep'):$address->city;
        $address->state=$request->filled('state')?$request->input('state'):$address->state;
        $address->save();

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }
}
