<?php
namespace controllers;

use models\user as User;
use repository\userRepository as UserRepository;

class UserController{
    private $repository;

    public function __construct(){
        $this->repository = new UserRepository();
    }

    public function signup(){
        if($_POST){
            //generar ID
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $user = new User(123,$name,$email,$password,false);
            ($this->repository)->add($user);

        } else {
            echo "error";
        }
    }

    public function login(){
        if($_POST){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = ($this->repository)->getOne($email);
            if($user != null){
                if ($user->getPassword() == $password)
                {
                    echo 'acceso permitido';
                }
                else {
                    echo 'contraseña incorrecta';
                }
            } else {
                echo 'usuario no encontrado';
            }
        } else {
            echo "error";
        }
    }
}

?>