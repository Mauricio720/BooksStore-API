<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSuccess;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    private  $badgesArray=[
        'success'=>'bg-success',
        'pendent'=>'bg-warning',
        'cancel'=>'bg-danger',
    ];

    private  $statusTranslators=[
        'success'=>'Finalizado',
        'cancel'=>'Cancelado',
        'pendent'=>'Pendente'
    ];
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $orders=Order::query();
        $orders=$orders->join('users','orders.users_id','users.id');
        $search="";
        $date="";
        $status="";

        if($request->filled('search')){
            $search=$request->input('search');
            $orders=$orders->where('users.name','LIKE','%'.$search.'%')
            ->orWhere('users.email','LIKE','%'.$search.'%');
        }

        if($request->filled('date')){
            $date=$request->input('date');
            $orders->where('orders.created_at','LIKE','%'.$date.'%');
        }

        if($request->filled('status')){
            $status=$request->input('status');
            $orders->where('status',$status);
        }

        $orders=$orders->orderBy('created_at','ASC')
        ->get([
            'orders.id',
            'subtotal',
            'total',
            'status',
            'users.name as name_user',
            'users.email',
            'orders.created_at',
            'orders.updated_at',
        ]);

        return view('orders',[
            'orders'=>$orders,
            'badgesArray'=>$this->badgesArray,
            'statusTranslators'=>$this->statusTranslators,
            'search'=>$search,
            'status'=>$status,
            'date'=>$date,
        ]);
    } 

    public function changeStatus($id,$status){
        $order=Order::where('id',$id)->first();
        $order->status=$status;
        $order->save();

        if($status==='success'){
            Mail::send(new PaymentSuccess($order));
        }

        if($status==='cancel'){
            Mail::send(new PaymentSuccess($order));
        }

        return redirect()->route('orders');
    }
    
    public function seeDetail($id){
        $order=Order::where('id',$id)->with('user')->first();
        $ordersItems=OrderItem::where('orders_id',$id)
        
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

        return view('seeOrder',[
            'order'=>$order,
            'orderItems'=>$ordersItems,
            'badgesArray'=>$this->badgesArray,
            'statusTranslators'=>$this->statusTranslators,
        ]);
    }
}
