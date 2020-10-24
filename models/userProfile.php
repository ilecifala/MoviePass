<?php
namespace models;


class UserProfile{

    private $id;
    private $firstName;
    private $lastName;
    private $dni;


    public function __construct($id, $firstName, $lastName, $dni){
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dni = $dni;
    }

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

    public function getFirstName(){
		return $this->firstName;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
    }
    
    public function setDni($dni){
		$this->dni = $dni;
	}

	public function getDni(){
		return $this->dni;
	}



}



?>