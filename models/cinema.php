<?php
namespace models;



class Cinema{
    private $id;
    private $name;
    private $capacity;
    private $address1;
    private $address2;
    private $city;
    private $postal;
    private $province;
    private $ticketPrice;

    public function __construct($name = "vacio", $capacity = -1, $address1 = "vacio", $address2 = "vacio", $city = "vacio", $postal = -1, $province = "vacio", $ticketPrice = "vacio"){
        $this->id = uniqid();
        $this->name = $name;
        $this->capacity = $capacity;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->postal = $postal;
        $this->province = $province;
        $this->ticketPrice = $ticketPrice;
        
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function setCapacity($capacity){
        $this->capacity = $capacity;
    }

    public function getAddress1(){
        return $this->address1;    }
    

    public function setAddress($address1){
        $this->address1 = $address1;
    }

    public function getAddress2(){
        return $this->address2;
    }
    
    public function setAddress2($address2){
        $this->address2 = $address2;
    }

    public function getCity(){
        return $this->city;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function getPostal(){
        return $this->postal;
    }

    public function setPostal($postal){
        $this->postal = $postal;
    }

    public function getProvince(){
        return $this->province;
    }

    public function setProvince($province){
        $this->province = $province;
    }

    public function getTicketPrice(){
        return $this->ticketPrice;
    }

    public function setTicketPrice($ticketPrice){
        $this->ticketPrice = $ticketPrice;
    }

}







?>