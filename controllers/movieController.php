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
        //TODO check if logged and admin

        $this->genreDaos->updateFromAPI();
        $this->movieDaos->updateFromAPI();
    }

        
    public function index(){
        header("Location: show");
    }


    public function show($genreRequired = "all", $yearRequired = "all", $page = 1){

        $movies = $this->movieDaos->getAll();
        $genres = $this->genreDaos->getAll(); //this is used later in the view to display a dropdown

        //filter by genre
        if($genreRequired != "all"){
              $movies = array_filter($movies, function($movie) use($genreRequired){
                return in_array($genreRequired, $movie->getGenresId());
              });
        }

        //filter by year
        if($yearRequired != "all"){
            $movies = array_filter($movies, function($movie) use($yearRequired){
              return $yearRequired ==  explode('-', $movie->getReleaseDate())[0];
            });
        }


        $movies = array_slice($movies, 0, 12);
        

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