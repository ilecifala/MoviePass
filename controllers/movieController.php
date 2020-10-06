<?php
namespace controllers;
use models\movie as Movie;
use repository\movieRepository as MovieRepository;
use api\MovieDbInterface as MoviesApi;

class MovieController{

    private $movieRepo;
    private $api;

    public function __construct(){
        $this->movieRepo = new MovieRepository();
        $this->api = new MoviesApi();
    }

    public function updateFromAPI(){

		//TODO should check if logged and admin here?

        //should this have its own controller/repo? i'd be kinda overkill and could lead to db inconsistencies
        $this->movieRepo->updateGenres($this->api->getGenres());

        //get last 3 pages from api? idk
        for($i=1 ; $i< 4; $i++){
            $moviesApi = $this->api->getMovies($i);            
            foreach($moviesApi as $movie){
                if(!$this->movieRepo->exists($movie->getId())){
                    $this->movieRepo->add($movie);
                }
            }
        }
    }

    public function getAll(){		
		var_dump($this->movieRepo->getAll());
    }

    public function getMovie($id){
        echo $id;
        $movie = $this->movieRepo->getById($id);
        var_dump($movie);
    }

}
