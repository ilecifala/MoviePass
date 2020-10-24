<?php
namespace controllers;
use daos\MovieDaos as MovieDaos;
use daos\GenreDaos as GenreDaos;

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
        //$this->movieDaos->update();
        $this->show();
    }

        
    public function index(){
        //header("Location: show");
        $this->show();
    }


    public function show($genreRequired = "all", $yearRequired = "all", $page = 1){

        $movies = $this->movieDaos->getAll();
        $genres = $this->genreDaos->getAll(); //this is used later in the view to display a dropdown

        $page = intval($page);

        //filter by genre
        if($genreRequired != "all"){
              $movies = array_filter($movies, function($movie) use($genreRequired){
                return in_array($genreRequired, unserialize($movie->getGenreIds()));
              });
        }

        //filter by year
        if($yearRequired != "all"){
            $movies = array_filter($movies, function($movie) use($yearRequired){
              return $yearRequired ==  explode('-', $movie->getReleaseDate())[0];
            });
        }


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