<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

     /**
     * @OA\GET(
     *      path="/orders",
     *      summary="ORDERS",
     *      description="Rota para trazer e filtrar os pedidos",
     *      tags={"Pedidos"},
     *      security={{ "apiAuth": {} }},
     *      @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Buscar por data (Formato Y-m-d)",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Buscar por status (pendent,complete,cancel)",
     *         required=false,
     *      ),
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
    public function list(Request $request){
        $orders=Order::query();
        
        if($request->filled('date')){
            $orders->where('created_at','LIKE','%'.$request->input('date').'%');
        }
        
        if($request->filled('status')){
            $orders->where('status',$request->input('status'));
        }
        
        if($request->filled('order_by')){
            $orders->orderBy('created_at',$request->input('order_by'));
        }else{
            $orders->orderBy('created_at','ASC');
        }
            
        $orders=$orders->where('users_id',Auth::user()->id)
            ->with('ordersItems.book')
            ->get();

        $allOrders = $orders->map(function ($order) {
            return [
                'id'=>$order->id,
                'subtotal'=>$order->subtotal,
                'total'=>$order->total,
                'status'=>$order->status,
                'link_payment'=>$order->link_payment,
                'users_id'=>$order->users_id,
                'date'=> date('d-m-Y h:i:s',strtotime($order->created_at)),
                
                'order_items'=> $order->ordersItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->book->title,
                        'description' => $item->book->description,
                        'img' => $item->book->img,
                        'author' => $item->book->author,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total_price' => $item->total_price
                    ];
                })
            ]; 
        });

        return response()->json([
            'status' => 'success',
            'orders'=>$allOrders,
        ]);
    }
       
    /**
     * @OA\POST(
     *      path="/orders",
     *      summary="REGISTRO DO PEDIDO",
     *      description="Rota para registro do pedido",
     *      security={{ "apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OrderRequest")
     *      ),
     *      tags={"Pedidos"},
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
    public function add(OrderRequest $request){
        $order=new Order();
        $order->subtotal=$request->input('total');
        $order->total=$request->input('total');
        $order->status='pendent';
        $order->link_payment="/";
        $order->users_id=Auth::guard('api')->user()->id;
        $order->save();

        $ordersItems=$request->input('orders_items');
      
        foreach ($ordersItems as $item) {
            $orderItem=new OrderItem();
            $orderItem->quantity=$item['quantity'];
            $orderItem->unit_price=$item['unit_price'];
            $orderItem->total_price=$item['total_price'];
            $orderItem->orders_id=$order->id;
            $orderItem->books_id=$item['id_book'];
            $orderItem->save();
        }

        $ordersItems=OrderItem::where('orders_id',$order->id)
            ->join('books','order_items.books_id','books.id')
            ->get([
                'order_items.id',
                'books.title',
                'books.description',
                'books.img',
                'books.author',
                'order_items.quantity',
                'order_items.unit_price',
                'order_items.total_price',
                'order_items.orders_id'
            ]);

        return response()->json([
            'status' => 'success',
            'order'=>$order,
            'ordersItems'=> $ordersItems
        ]);
    }

    public function cancel($id){
        $order=Order::where('id',$id)->first();
        
        if(!$order){
            return response()->json([
                'status' => 'failed',
                'message'=> 'Pedido não encontrada'
            ]);
        }
        $order->status='cancel';
        $order->save();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
