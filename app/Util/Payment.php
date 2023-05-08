<?php

namespace App\Util;
use App\Util\Interfaces\PaymentInter;

class Payment{

    public  $paymentMethod;
    
    public function __construct(PaymentInter $paymentMethod){
        
        $this->paymentMethod=$paymentMethod;
    }

    public function doPayment(){
        return $this->paymentMethod->doPayment();
    }
    
    public function notificationPayment(){
        return $this->paymentMethod->notificationPayment();
    }

    public function cardProcess(){
    }

    public function bankSlipProcess(){

    }
   
}