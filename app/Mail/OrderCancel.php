<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user=User::where('id',$this->order->users_id)->first();
        
        $this->subject('Pedido Cancelado!');
        $this->to($user->email,$user->name);

        return $this->markdown('mail.cancelOrder',[
            'order'=>$this->order,
            'user'=>$user
        ]);
    }
}
