<?php
namespace api;

use models\movie as Movie;
use models\genre as Genre;
class MovieDbInterface{

    const ROOT_URL = "https://api.themoviedb.org/3/";
    const IMAGE_URL = "http://image.tmdb.org/t/p/w500/";
    const DEFAULT_LANG = "ES_es";

    public function getFullMovies(){
        $movies = [];
        for($i=1 ; $i< 11; $i++){
            $movies[] = $this->getMovies($i);
        }
        var_dump($movies);
        return $movies;

    }


    public function getMovies($page = 1){

        $url = self::ROOT_URL . "movie/now_playing?api_key=" . MOVIEDB_KEY . "&language=" . self::DEFAULT_LANG . "&page=" . $page;
        $resultsRaw = file_get_contents($url);
        $results = json_decode($resultsRaw, true);   
        $movies = $results['results'];

        foreach($results['results'] as $jsonMovie){
            $movie = new Movie($jsonMovie['id'], $jsonMovie['original_title'], self::IMAGE_URL . $jsonMovie['poster_path'], $jsonMovie['original_language'], $jsonMovie['genre_ids'], $jsonMovie['release_date']);
            $resultMovies[] = $movie;
        }
        return $resultMovies;
    }

    public function getGenres(){

        $url = self::ROOT_URL . "genre/movie/list?api_key=" . MOVIEDB_KEY . "&language=" . self::DEFAULT_LANG;
        $resultsRaw = file_get_contents($url);
        $results = json_decode($resultsRaw, true);   
        $genres = $results['genres'];

        foreach($genres as $genre){
            $resultGenres[] = new Genre($genre['id'], $genre['name']);
        }
        return $resultGenres;

    }
}










?>