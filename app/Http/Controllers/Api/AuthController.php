<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * @OA\POST(
     *      path="/logged",
     *      summary="USUARIO LOGADO",
     *      description="Rota para trazer usuário logado",
     *      security={{ "apiAuth": {} }},
     *      tags={"Autenticação"},
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          
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
    
    public function logged()
    {
        return Auth::guard('api')->user()->load('address');
    }

    /**
     * @OA\POST(
     *      path="/login",
     *      summary="LOGIN",
     *      description="Rota para realização de login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthRequest")
     *      ),
     *      tags={"Autenticação"},
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          
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

    public function login(AuthRequest $request)
    {

        $token = Auth::guard('api')->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'type'=>1
        ]);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email e/ou senha estão incorretos',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        if($user->block){
            return response()->json([
                'status' => 'failed',
                'message' => 'Usuário Bloqueado',
            ],400);
        }
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }

     /**
     * @OA\POST(
     *      path="/user",
     *      summary="REGISTRO USUÁRIO",
     *      description="Rota para registro do usuário",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *      ),
     *      tags={"Autenticação"},
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          
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

    public function register(UserRequest $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->type = 1;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $address=new Address();
        $address->street=$request->input('street');
        $address->number=$request->input('number');
        $address->neighborhood=$request->input('neighborhood');
        $address->city=$request->input('city');
        $address->cep=$request->input('cep');
        $address->state=$request->input('state');
        $address->users_id=$user->id;
        $address->save();

        $token = Auth::guard('api')->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'type'=>1
        ]);

        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user()->load('address'),
            'token' => $token,
        ],201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'token' => Auth::refresh(),
        ]);
    }

    public function unauthorized()
    {
        return response()->json([
            'status' => 'Não Autorizado',
        ]);
    }

}