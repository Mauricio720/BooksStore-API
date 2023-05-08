<?php

namespace App\Util\Interfaces;

interface Payer {

    public function getName();
    public function setName($name);
    public function getLastName();
    public function setLastName($lastname);
    public function getEmail();
    public function setEmail($email);
    public function getCpf();
    public function setCpf($cpf);
    public function getStreet();
    public function setStreet($street);
    public function getNumber();
    public function setNumber($number);
    public function getNeighboorhood();
    public function setNeighboorhood($neighboorhood);
    public function getCity();
    public function setCity($city);
    public function getState();
    public function setState($state);
    public function getCountry();
    public function setCountry($country);
    public function getCep($justNumber);
    public function setCep($cep);

    
    

}