<?php

namespace App\Util\Interfaces;

interface PaymentItem{

    public function getId();
    public function setId($id);
    public function getTitle();
    public function setTitle($title);
    public function getValue();
    public function setValue($value);
    public function getQuantity();
    public function setQuantity($quantity);
    public function getUnitPrice();
    public function setUnitPrice($unitPrice);
    public function getCurrencyId();
    public function setCurrencyId($currencyId);
    public function getDescription();
    public function setDescription($description);
}