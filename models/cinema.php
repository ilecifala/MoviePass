<?php
namespace models;



class Cinema{
    private $id;
    private $name;
    private $capacity;
    private $address;
    private $city;
    private $zip;
    private $province;
    private $ticketPrice;

    public function __construct($name = "vacio", $capacity = -1, $address = "vacio", $city = "vacio", $zip = -1, $province = "vacio", $ticketPrice = "vacio"){
        $this->name = $name;
        $this->capacity = $capacity;
        $this->address = $address;
        $this->city = $city;
        $this->zip = $zip;
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

    public function getAddress(){
        return $this->address;
    }    

    public function setAddress($address){
        $this->address = $address;
    }

    public function getCity(){
        return $this->city;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function getZip(){
        return $this->zip;
    }

    public function setZip($zip){
        $this->zip = $zip;
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