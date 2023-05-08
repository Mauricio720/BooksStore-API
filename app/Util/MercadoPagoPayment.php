<?php

namespace App\Util;

use App\Util\Interfaces\PaymentInter;
use MercadoPago\Preference as MPPreference;
use MercadoPago\Item as MPItem;
use MercadoPago\SDK;
use MercadoPago\Payer as MPPayer;


class MercadoPagoPayment implements PaymentInter{
    private $token;
    private $payerInfo;
    private $paymentItens=[];
    private $externalReference;
    
    public function __construct(String $token){
        $this->setToken($token);
        Sdk::setAccessToken($this->getToken());
    }

    public function getPayerInfo(){
        return $this->payerInfo;
    }

    public function setPayerInfo($payer){
        $mppayer=new MPPayer();
        $mppayer->name = $payer->getName();
        $mppayer->surname = $payer->getLastName();;
        $mppayer->email = $payer->getEmail();;
        $mppayer->date_created = date('Y-m-d');
        
        $mppayer->address = array(
          "street_name" => $payer->getStreet(),
          "street_number" => $payer->getNumber(),
          "zip_code" => $payer->getCep(true)
        );

        $this->payerInfo=$mppayer;
    }

    public function setPayment($paymentItem){
        $this->paymentItem=$paymentItem;
    }
    
    public function getPaymentItens(){
        return $this->paymentItens;
    }
    
    public function setPaymentItem($paymentItem){
        $this->paymentItens[]=$paymentItem;
    }
    
    public function doPayment(){
        $preference=new MPPreference();
        $preference->external_reference=$this->getExternalReference();
        $paymentsItens=$this->getPaymentItens();
        
        if(count($paymentsItens)<2){
            $paymentItem=$paymentsItens[0];
           
            $item = new MPItem();
            $item->title = $paymentItem->getTitle();
            $item->quantity = $paymentItem->getQuantity();
            $item->unit_price =$paymentItem->getUnitPrice();
            $preference->items = array($item);
        }else{
            foreach ($paymentsItens as $key => $item) {
                $item = new MPItem();
                $item->title = $this->item->getTitle();
                $item->quantity = $this->item->getQuantity();
                $item->unit_price = $this->item->getUnitPrice();
            }
        }

        if($this->getPayerInfo() != ""){
            $preference->payer=$this->getPayerInfo();
        }
        $preference->save();

        return $preference->init_point;
    }
    
    public function notificationPayment(){
        $url="";

        if($_GET['topic']=='payment'){
            $url="https://api.mercadopago.com/v1/payments/";
        }else if($_GET['topic']=='merchant_order'){
            $url="https://api.mercadopago.com/v1/merchant_orders/";
        }

        $url=$url.$this->getExternalReference();
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$this->getToken()
            ]
        );

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_FAILONERROR,true);

        $payment=curl_exec($curl);

        if($errno = curl_errno($curl)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }

        curl_close($curl);

        $payments=json_decode($payment);
        
        $status= $payments->status;
        $info=[];
        $info['status']=$status;
        $info['externalReference']=$payments->external_reference;
        
        return $info;
        
    }

    public function getDate(){

    }
    
    public function setDate($date){

    }
    public function getTime(){

    }
    
    public function setTime($time){

    }

    public function getToken(){
        return $this->token;
    }
    
    public function setToken($token){
        $this->token=$token;
    }

    public function getExternalReference(){
        return $this->externalReference;
    }
    
    public function setExternalReference($externalReference){
        $this->externalReference=$externalReference;
    }
    
    public function cardProcess(){

    }

    public function bankSlipProcess() {
        
    }


}