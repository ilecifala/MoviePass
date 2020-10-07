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

        //include view here
        echo "<pre>";
        var_dump($movies);
        echo "</pre>";
    }


    public function getMovie($id){
        $movie = $this->movieDaos->getById($id);
        var_dump($movie);
    }

}

