<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * @OA\Schema(
 *      title="Auth Register Request",
 *      description="order request body data",
 *      type="object",
 *      required={"total","orders_items"}
 * )
 */

class OrderRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="total",
     *      type="float",
     *      description="Total do pedido",
     *      example="21.98"
     * )
     *
     * @var string
     */
    public $total;

    /**
     * @OA\Property(
     *      title="order_items",
     *      description="Items do pedido",
     *      type="array",
     *      @OA\Items(
     *          type="object",
     *          required={"id_book", "quantity", "unit_price", "total_price"},
     *          @OA\Property(
     *              property="id_book",
     *              type="integer",
     *              description="ID do livro",
     *              example=1
     *         ),
     *         @OA\Property(
     *             property="quantity",
     *             type="integer",
     *             description="Quantidade do livro",
     *             example=2
     *         ),
     *        @OA\Property(
     *              property="unit_price",
     *              type="number",
     *              format="float",
     *              description="Preço unitário do livro",
     *              example=10.99
     *         ),
     *          @OA\Property(
     *              property="total_price",
     *              type="number",
     *              format="float",
     *              description="Preço total do livro",
     *              example=21.98
     *          ) 
     *     )
     * )
     *
     * @var string
     */
    
    public $orders_items;
    
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
            'total' => ['required'],
            'orders_items'=>['required','array'],
            'orders_items.*.id_book'=>['required', 'exists:books,id'],
            'orders_items.*.quantity'=>['required'],
            'orders_items.*.unit_price'=>['required'],
            'orders_items.*.total_price'=>['required']
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
