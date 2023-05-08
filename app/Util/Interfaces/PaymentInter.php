<?php

namespace App\Util\Interfaces;

use App\Util\ItemPayment;

interface PaymentInter{
    
    public function getPayerInfo();
    public function setPayerInfo(Payer $payer);
    public function setPaymentItem(ItemPayment $payer);
    public function getPaymentItens();
    public function setPayment($paymentItem);
    public function doPayment();
    public function notificationPayment();
    public function getDate();
    public function setDate($date);
    public function getTime();
    public function setTime($time);
    public function getToken();
    public function setToken($token);
    public function getExternalReference();
    public function setExternalReference($externalReference);
    public function cardProcess();
    public function bankSlipProcess();
    
  

}