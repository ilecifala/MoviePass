<?php
namespace controllers;
use models\movie as Movie;
use daos\MovieDaos as MovieDaos;
use daos\GenreDaos as GenreDaos;

class MovieController{

    private $movieDaos;

    public function __construct(){
        $this->movieDaos = new MovieDaos();
    }

    public function update(){
        //TODO check if logged and admin

        $genreDaos = new GenreDaos();
        $genreDaos->updateFromAPI();

        $this->movieDaos->updateFromAPI();
    }


    public function getAll($genre = "all", $year = "all"){

        $movies = $this->movieDaos->getAll();
        if($_GET){
            if($_GET['year'] == ''){
                $year = 'all';
            }
            if ($_GET['genre'] == ''){
                $genre = 'all';
            }
        }

        //filter by genre
        if($genre != "all"){
              $movies = array_filter($movies, function($movie) use($genre){
                return in_array($genre, $movie->getGenresId());
              });
        }

        //filter by year
        if($year != "all"){
            $movies = array_filter($movies, function($movie) use($year){
              return $year ==  explode('-', $movie->getReleaseDate())[0];
            });
        }

        //echo 'movieController/getAll y los parametros: genre: ' . $genre . ' | year: ' . $year;
        //include view here
        //echo "<pre>";
        //var_dump($movies);
        //echo "</pre>";
        
        if (empty($movies)){
            echo 'no se encontraron resultados';
        }
        
        include('views/moviesList.php');
    }


    public function getMovie($id){
        $movie = $this->movieDaos->getById($id);
        var_dump($movie);
    }

}

