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
            
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "login.php");
            require_once(VIEWS_PATH . "footer.php");

        } else {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "signup.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function login(){
        if($_POST){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = ($this->daos)->getOne($email);
            if($user != null){
                if ($user->getPassword() == $password){
                    $_SESSION['user'] = $user;
                    require_once(VIEWS_PATH . "header.php");
                    require_once(VIEWS_PATH . "login.php"); //acá tendría que ir otra vista, o llamar o movieController->show() o algo así, no sé.
                    require_once(VIEWS_PATH . "footer.php");
                    return;

                }else {
                    //TODO
                    echo 'contraseña incorrecta';
                }
            } else {
                //TODO
                echo 'usuario no encontrado';
            }
        }
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "login.php");
        require_once(VIEWS_PATH . "footer.php");

       
    }

    public function logout(){
        $_SESSION['user'] = null;
        $this->login();
    }
}

?>