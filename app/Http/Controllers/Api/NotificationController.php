<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Util\MercadoPagoPayment;
use App\Util\Payment;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notificationMercadoPago(Request $request){
        $reference=$request->input('id');
        $_GET['topic'];
        $content=file_get_contents('mplog.txt'); 

        $mercadoPago=new MercadoPagoPayment(env('TOKEN_PAYMENT'));
        $mercadoPago->setExternalReference($reference);
        
        $payment=new Payment($mercadoPago);
        $info=$payment->notificationPayment();
        $externalReference=$info['externalReference'];
        $status=$info['status'];

        $newContent="Reference: ".$reference." Topic: ".$_GET['topic']." data:".date('d/m/Y H:i:s')
        ." status: ".$status;
        $newContent=$content."\n".$newContent;
        file_put_contents('mplog.txt',$newContent);

        if($status=='approved'){
            $order=Order::where('external_reference',$externalReference)->first();
            $order->status='success';
            $order->save();
        }
    }
}
