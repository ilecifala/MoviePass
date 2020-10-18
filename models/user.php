<?php
namespace models;

class User{
	private $id;
	private $firstName;
	private $lastName;
    private $email;
    private $password;
    private $dni;
    private $idRol;

    public function __construct($id = '', $firstName = '', $lastName ='', $email = '', $password = '', $dni = '', $idRol = ''){
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
        $this->email = $email;
		$this->password = $password;
        $this->dni = $dni;
		$this->idRol = $idRol;
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

	public function setFirstName($name){
		$this->firstName = $firstName;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function setDni($dni){
		$this->dni = $dni;
	}

	public function getDni(){
		return $this->dni;
	}

	public function idRol(){
		return $this->idRol;
	}

	public function setIdRol($idRol){
		$this->idRol = $idRol;
	}
}



?>