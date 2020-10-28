<?php
namespace models;


class Room implements \JsonSerializable{

    private $id;
    private $name;
    private $price;
	private $capacity;
	private $shows;

    public function __construct($name = '', $price= -1, $capacity= -1, $shows = array()){
        $this->name = $name;
        $this->price = $price;
		$this->capacity = $capacity;
		$this->shows = $shows;
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

	public function getShows(){
		return $this->shows;
	}

	public function setShows($shows){
		$this->shows = $shows;
	}

	public function jsonSerialize(){
        return get_object_vars($this);
    }

}