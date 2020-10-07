<?php
namespace api;

use models\movie as Movie;
use models\genre as Genre;

class MovieDbInterface{
    const ROOT_URL = "https://api.themoviedb.org/3/";
    const IMAGE_URL = "http://image.tmdb.org/t/p/w500";
    const DEFAULT_LANG = "es";

    public function getMovies($page = 1, $lang = self::DEFAULT_LANG){
        $url = self::ROOT_URL . "movie/now_playing?api_key=" . MOVIEDB_KEY . "&language=" . $lang . "&page=" . $page;
        $resultRaw = file_get_contents($url);
        $result = json_decode($resultRaw, true);   
        $movies = $result['results'];

        $resultMovies = array();
        foreach($movies as $jsonMovie){
            $movie = new Movie($jsonMovie['id'], $jsonMovie['original_title'], $jsonMovie['overview'], self::IMAGE_URL . $jsonMovie['poster_path'], $jsonMovie['original_language'], $jsonMovie['genre_ids'], $jsonMovie['release_date']);
            $resultMovies[] = $movie;
        }
        return $resultMovies;
    }

    public function getGenres($lang = self::DEFAULT_LANG){
        $url = self::ROOT_URL . "genre/movie/list?api_key=" . MOVIEDB_KEY . "&language=" . $lang;
        $resultRaw = file_get_contents($url);
        $result = json_decode($resultRaw, true);   
        $genres = $result['genres'];

        foreach($genres as $genre){
            $resultGenres[] = new Genre($genre['id'], $genre['name']);
        }
        return $resultGenres;
    }
}

?>