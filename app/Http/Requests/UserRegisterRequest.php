<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *      title="Auth Register Request",
 *      description="Auth request body data",
 *      type="object",
 *      required={"name","email","password","street","number","neighborhood"
 *      ,"city","cep","state"}
 * )
 */


class UserRegisterRequest extends FormRequest
{
    
    /**
     * @OA\Property(
     *      title="name",
     *      description="Nome do usuário",
     *      example="Pedro Souza"
     * )
     *
     * @var string
     */
    public $name;
    
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email do usuário",
     *      example="teste@hotmail.com"
     * )
     *
     * @var string
     */
    public $email;

     /**
     * @OA\Property(
     *      title="password",
     *      description="Senha do usuário",
     *      example="1234"
     * )
     *
     * @var string
     */
    public $password;

     /**
     * @OA\Property(
     *      title="cep",
     *      description="cep do usuário",
     *      example="05454-457"
     * )
     *
     * @var string
     */
    public $cep;

    
     /**
     * @OA\Property(
     *      title="street",
     *      description="Rua do usuário",
     *      example="Principal"
     * )
     *
     * @var string
     */
    public $street;

     /**
     * @OA\Property(
     *      title="number",
     *      description="Numero de endereço do usuário",
     *      example="4547"
     * )
     *
     * @var string
     */
    public $number;


     /**
     * @OA\Property(
     *      title="neighborhood",
     *      description="bairro do usuário",
     *      example="Guaianases"
     * )
     *
     * @var string
     */
    public $neighborhood;

    /**
     * @OA\Property(
     *      title="city",
     *      description="cidade do usuário",
     *      example="São Paulo"
     * )
     *
     * @var string
     */
    public $city;

    
    /**
     * @OA\Property(
     *      title="state",
     *      description="estado do usuário",
     *      example="São Paulo"
     * )
     *
     * @var string
     */
    public $state;

    
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['string'],
            'email' => ['email','unique:users', 'required'],
            'password' => ['string', 'required'],
            'street' =>  ['string', 'required'],
            'number' =>  ['string', 'required'],
            'neighborhood' =>  ['string', 'required'],
            'city' =>  ['string', 'required'],
            'cep' =>  ['string','formato_cep', 'required'],
            'state' =>  ['string', 'required'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'password' => 'senha',
            'street' => 'rua',
            'number' => 'numero',
            'neighborhood' => 'bairro',
            'city' => 'cidade',
            'state' => 'estado',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors()->first(),
            'status' => 400
        ], 400));
    }
    
}
