<?php
namespace models;


class Room{

    private $id;
    private $name;
    private $price;
    private $capacity;
    private $idCinema;

    public function __construct($name = '', $price= -1, $capacity= -1, $idCinema = -1){
        $this->name = $name;
        $this->price = $price;
        $this->capacity = $capacity;
        $this->idCinema = $idCinema;
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

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getCapacity(){
		return $this->capacity;
	}

	public function setCapacity($capacity){
		$this->capacity = $capacity;
	}

	public function getIdCinema(){
		return $this->idCinema;
	}

	public function setIdCinema($idCinema){
		$this->idCinema = $idCinema;
	}

}