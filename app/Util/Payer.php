<?php

namespace App\Util;

use App\Util\Interfaces\Payer as InterfacesPayer;

class Payer implements InterfacesPayer{

    private $name;
    private $lastname;
    private $email;
    private $cpf;
    private $street;
    private $number;
    private $neighboorhood;
    private $city;
    private $state;
    private $country;
    private $cep;

    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name=$name;
    }
    
    public function getLastName(){
        return $this->lastname;
    }
    
    public function setLastName($lastname){
        $this->lastname=$lastname;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($email){
        $this->email=$email;
    }

    public function getCpf(){
        return $this->cpf;
    }
    
    public function setCpf($cpf){
        $this->cpf=$cpf;
    }
    
    public function getStreet(){
        return $this->street;
    }

    public function setStreet($street){
        $this->street=$street;
    }

    public function getNumber(){
        return $this->number;
    }

    public function setNumber($number){
        $this->number=$number;
    }

    public function getNeighboorhood(){
        return $this->neighboorhood;
    }

    public function setNeighboorhood($neighboorhood){
        $this->neighboorhood=$neighboorhood;
    }
    
    public function getCity(){
        return $this->city;
    }
    
    public function setCity($city){
        $this->city=$city;
    }

    public function getState(){
        return $this->state;
    }

    public function setState($state){
        $this->state=$state;
    }

    public function getCountry(){
        return $this->country;
    }

    public function setCountry($country){
        $this->country=$country;
    }
    
    public function getCep($justNumber=false){
        if($justNumber){
            $cepJustNumber=intVal(str_replace('-','',$this->cep)); 
            $this->cep=$cepJustNumber;
        }
        return $this->cep;
    }

    public function setCep($cep){
        return $this->cep;
    }
}