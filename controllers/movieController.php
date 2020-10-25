<?php
namespace controllers;
use daos\MovieDaos as MovieDaos;
use daos\GenreDaos as GenreDaos;
use models\movie as Movie;

class MovieController{

    private $movieDaos;
    private $genreDaos;

    public function __construct(){
        $this->movieDaos = new MovieDaos();
        $this->genreDaos = new GenreDaos();
    }

    public function update(){

        if($_SESSION['user'] == null || $_SESSION['user']->getIdRol() != 1){
            header("HTTP/1.1 403");
            //or redirect to login, idk
            //$c = new UserController();
            //$c->login();            
            return;
        }


        $this->genreDaos->update();
        $this->movieDaos->update();
        $this->show();
    }

        
    public function index(){
        //header("Location: show");
        $this->show();
    }

    public function getMovies($genreRequired = "all", $yearRequired = "all", $name = null, $page = 1){

       // $response = $this->movieDaos->getAll();
        //var_dump($response);
        //echo json_encode($response, JSON_FORCE_OBJECT);
        $movies = $this->movieDaos->getMoviesFiltered($genreRequired, $yearRequired, $name, $page);
        //convert to array

        echo json_encode($movies);
        /*
        echo "<pre>";
        echo json_encode($movies, JSON_PRETTY_PRINT);
        echo "----";
        echo json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        echo "</pre>";
        */
    }


    public function show($genreRequired = "all", $yearRequired = "all", $page = 1){

        
        $movies = $this->movieDaos->getAll();
        $genres = $this->genreDaos->getAll(); //this is used later in the view to display a dropdown

        $page = intval($page);

        
        $years = array_column($this->movieDaos->getMoviesYear(),'year');



        
        //pagination
        $limit = 16;//limit to show per page
        $totalMovies = count($movies);
        $totalPages = intval(ceil($totalMovies / $limit));
        $offset = ($page - 1) * $limit;
        if($offset < 0) $offset = 0;

        $movies = array_slice($movies, $offset, $limit);
        

        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "index.php");
        require_once(VIEWS_PATH . "footer.php");
    }


    public function details($id){
        $movie = $this->movieDaos->getById($id);
        echo "<pre>";
        var_dump($movie);
        echo "</pre>";
    }

}