<?php
namespace controllers;
use daos\showDaos as ShowDaos;
use daos\cinemaDaos as CinemaDaos;
use daos\GenreDaos as GenreDaos;
use daos\MovieDaos as MovieDaos;
use models\show as Show;
use controllers\movieController as MovieController;


class ShowController{
    private $showDaos;
    private $cinemaDaos;
    private $genreDaos;
    private $movieDaos;

    public function __construct(){
        $this->showDaos = new ShowDaos();       
        $this->cinemaDaos = new CinemaDaos();  
        $this->genreDaos = GenreDaos::getInstance();  
        $this->movieDaos = new MovieDaos();  
    }

    public function index(){

        //check if user is logged and has admin privileges
        if(!isset($_SESSION['user']) || $_SESSION['user']->getIdRol() != 1){
            header("HTTP/1.1 403");           
            return;
        }

        $shows = $this->showDaos->getAll();

        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "showTable.php");
        require_once(VIEWS_PATH . "footer.php");
    }

    public function add(){

        //check if user is logged and has admin privileges
        if(!isset($_SESSION['user']) || $_SESSION['user']->getIdRol() != 1){
            header("HTTP/1.1 403");           
            return;
        }

        //this is used later in the view to display dropdowns
        $genres = $this->genreDaos->getAll(); 
        $years = array_column($this->movieDaos->getMoviesYear(),'year');

        $cinemas = $this->cinemaDaos->getAllWithRooms();
        
        if ($_POST){
            
            $idMovie = $_POST['movieId'];
            $date = $_POST['time'];
            $idRoom = $_POST['roomId'];
            $idCinema = $_POST['cinemaId'];

            $show = new Show($idMovie, $idRoom, $date);

            //do the verification (SQL, PHP?)
            $result = $this->showDaos->verifyDate($show, $idCinema);
            $error = null;
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
            if(!empty($result)){
                foreach($result as $res){
                    if($res['id_cinema'] != $idCinema){
                        $error = 'No se puede agregar la misma película un mismo día a distintos cines';
                    }
                }
            }
            $result = $this->showDaos->verifyDatetime($show);
            foreach($result as $res){
                echo abs($res['dif_minutes']).'adadasdadad';
                if (abs($res['dif_minutes']) < 15){
                    $error = 'Ya hay una función en ese horario.';
                }
            }
            if($error == null){
                $this->showDaos->add($show);
                $this->index();
            } else {
                require_once(VIEWS_PATH . "header.php");
                require_once(VIEWS_PATH . "addShow.php");
                require_once(VIEWS_PATH . "footer.php");
            }
            
        } else {
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "addShow.php");
            require_once(VIEWS_PATH . "footer.php");
        }
    }

    public function remove($id){
        //check if user is logged and has admin privileges
        if(!isset($_SESSION['user']) || $_SESSION['user']->getIdRol() != 1){
            header("HTTP/1.1 403");           
            return;
        }
        
        $this->showDaos->remove($id);
        $this->index();
    }
}


?>

