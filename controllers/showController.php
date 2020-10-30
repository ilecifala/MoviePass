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

            echo $show->getDatetime();

            //do the verification (SQL, PHP?)
            $result = $this->showDaos->verifyShowDay($show, $idCinema);
            $error = null;
            if(!empty($result)){
                foreach($result as $res){
                    if($res['id_cinema'] != $idCinema){
                        $error = 'No se puede agregar la misma película un mismo día a distintos cines';
                    }
                }
            }

            $shows3Days = $this->showDaos->verifyShowDatetimeOverlap($show);
            echo '<pre>';
            var_dump($shows3Days);
            echo '</pre>';

            echo $valid = $this->verify15Minutes($shows3Days, $show);
            
            if(!$valid){
                $error = 'Ya hay una funcion a esa hora.';
            }
            if($error == null){
                //$this->showDaos->add($show);
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

    private function verify15Minutes($shows3Days, $_show){
        $movie = $this->movieDaos->getById($_show->getIdMovie());
        $durationSeconds = ($movie->getDuration() + 15) * 60;

        echo $showTime = strtotime($_show->getDatetime());
        echo '<br>';
        echo $endShow = strtotime($_show->getDatetime()) + $durationSeconds;
        echo '<br>';

        echo date('Y-m-d H:i:s', $showTime);
        echo '<br>';
        echo date('Y-m-d H:i:s', $endShow);
        echo '<br>';

        $valid = true;

        foreach($shows3Days as $show){
            $seconds = strtotime($show->getDatetime()) + $durationSeconds;
            $result = abs($showTime - $seconds) / 60;
            
            echo date('Y-m-d H:i:s', strtotime($show->getDatetime()));
            echo '<br>'; 
            echo strtotime($show->getDatetime());
            echo '<br>'; 
            //Si el final del show que queremos agregar es despues de la fecha de inicio de la funcion ya agregada en la bd
            if($endShow > strtotime($show->getDatetime())){
                echo 'primer if';
                $valid = false;
            }
            
            //Si el fin del show de la bd es antes del inicio del show que queremos agregrar
            if((strtotime($show->getDatetime()) + $durationSeconds) < $showTime){
                $valid = false;
                echo 'segundo if';
            }
        }
        return $valid;
    }
}


?>

