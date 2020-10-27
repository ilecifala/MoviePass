<?php
namespace controllers;

use models\user as User;
use models\userProfile as Profile;
use daos\userDaos as UserDaos;
use daos\userProfileDaos as UserProfileDaos;

class UserController{
    private $daos;
    private $userProfileDaos;

    public function __construct(){
        $this->daos = new UserDaos();
        $this->userProfileDaos = new UserProfileDaos();
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
        $_SESSION['profile'] = null;
        $this->login();
    }

    public function profile(){
        if($_POST){
            if(!isset($_SESSION['profile'])){
                $profile = new Profile();
                if($_POST['firstName'] != null){
                    $profile->setFirstName($_POST['firstName']);
                }
                if($_POST['lastName'] != null){
                    $profile->setLastName($_POST['lastname']);
                }
                if($_POST['dni'] != null){
                    $profile->setDni($_POST['dni']);
                }
                $profile->setIdUser($_SESSION['user']->getId());
                $_SESSION['profile'] = $profile;
                $this->userProfileDaos->add($profile); 
            }else{
                $profile = $_SESSION['profile'];
                echo $profile->getLastName();
                $this->userProfileDaos->modify($profile);
            }
            
        }
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "profile.php");
        require_once(VIEWS_PATH . "footer.php");
    }
}

?>