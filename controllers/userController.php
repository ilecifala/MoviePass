<?php
namespace controllers;

use models\user as User;
use daos\userDaos as UserDaos;

class UserController{
    private $daos;

    public function __construct(){
        $this->daos = new UserDaos();
    }

    public function signup(){
        
        if($_POST){
            //generar ID
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $user = new User(123,$name,$email,$password,false);
            ($this->daos)->add($user);
        }

        header('location: signup.php');
    }

    public function login(){
        if($_POST){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = ($this->daos)->getOne($email);
            if($user != null){
                if ($user->getPassword() == $password)
                {
                    $_SESSION['loggedUser'] = $user;
                    echo 'acceso permitido';
                }
                else {
                    echo 'contraseña incorrecta';
                }
            } else {
                echo 'usuario no encontrado';
            }
        }
        include('views/login.php');
    }
}

?>