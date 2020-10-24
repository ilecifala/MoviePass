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
            $email = $_POST['email'];            
            $password = $_POST['password'];            
            if($this->daos->exists($email)){
                echo 'Ya hay un usuario registrado con ese email';
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "signup.php");
                require_once(VIEWS_PATH . "footer.php");
            }else{
                $user = new User($email,$password,2);
                $this->daos->add($user);  
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "login.php");
                require_once(VIEWS_PATH . "footer.php");          
            } 
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
            $user = $this->daos->getByEmail($email);
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