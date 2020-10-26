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
        $this->genreDaos = new GenreDaos();  
        $this->movieDaos = new MovieDaos();  
    }

    public function index(){

        //check if user is logged and has admin privileges
        if($_SESSION['user'] == null || $_SESSION['user']->getIdRol() != 1){
            header("HTTP/1.1 403");           
            return;
        }

        $this->showDaos->getAll();
       
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "showTable.php");
        require_once(VIEWS_PATH . "footer.php");
    }

    public function add(){

        //this is used later in the view to display dropdowns
        $genres = $this->genreDaos->getAll(); 
        $years = array_column($this->movieDaos->getMoviesYear(),'year');

        $cinemas = $this->cinemaDaos->getAll();

        
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "addShow.php");
        require_once(VIEWS_PATH . "footer.php");
        
    }
}


?>

