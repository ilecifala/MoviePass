<?php
namespace controllers;
use models\movie as Movie;
use daos\MovieDaos as MovieDaos;
use api\MovieDbInterface as MoviesApi;

class MovieController{

    private $movieDaos;
    private $api;

    public function __construct(){
        $this->movieDaos = new MovieDaos();
        $this->api = new MoviesApi();
    }

    public function updateFromAPI(){
		//TODO should check if logged and admin here?
        //should genres have their own controller/repo? i'd be kinda overkill and could lead to db inconsistencies
        $this->movieRepo->updateGenres($this->api->getGenres());

        //get all movies from API and add them
        $page = 1;
        do{
            $moviesApi = $this->api->getMovies($page);            
            foreach($moviesApi as $movie){
                if(!$this->movieRepo->exists($movie->getId())){
                    $this->movieRepo->add($movie);
                }
            }
            $page++;
        }while(!empty($moviesApi));
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
