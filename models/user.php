<?php
namespace models;

class User{
	private $id;
	private $name;
    private $email;
    private $password;
    private $isAdmin;
    //private $dni;

    public function __construct($id = '', $name = '', $email = '', $password = '', $isAdmin = ''){
		$this->id = $id;
		$this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
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

	public function getIsAdmin(){
		return $this->isAdmin;
	}

	public function setIsAdmin($isAdmin){
		$this->isAdmin = $isAdmin;
	}
}



?>