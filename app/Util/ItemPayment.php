<?php

namespace App\Util;

use App\Util\Interfaces\PaymentItem;

class ItemPayment implements PaymentItem{

    private $id;
    private $title;
    private $value;
    private $quantity;
    private $unitPrice;
    private $currencyId;
    private $description;

    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id=$id;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setTitle($title){
        $this->title=$title;
    }
    
    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value=$value;
    }
    
    public function getQuantity(){
        return $this->quantity;
    }

    public function setQuantity($quantity){
        $this->quantity=$quantity;
    }

    public function getUnitPrice(){
        return $this->unitPrice;
    }

    public function setUnitPrice($unitPrice){
        $this->unitPrice=$unitPrice;
    }
    public function getCurrencyId(){
        return $this->currencyId;
    }

    public function setCurrencyId($currencyId){
        $this->currencyId=$currencyId;
    }

    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description=$description;
    }
}