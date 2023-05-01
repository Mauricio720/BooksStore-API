<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *      title="Auth Request",
 *      description="Auth request body data",
 *      type="object",
 *      required={"email","password"}
 * )
 */

class AuthRequest extends FormRequest
{
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

      /**
     * @OA\Property(
     *      title="email",
     *      description="Email do login",
     *      example="teste@hotmail.com"
     * )
     *
     * @var string
     */
    public $email;

       /**
     * @OA\Property(
     *      title="password",
     *      description="Senha do login",
     *      example="1234"
     * )
     *
     * @var string
     */
    public $password;

    public function rules()
    {
        return [
            'email' => ['email', 'required'],
            'password' => ['string', 'required'],
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'senha'
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
