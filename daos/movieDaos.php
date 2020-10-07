<?php
namespace daos;
use daos\IDaos as IDaos;
use daos\genreDaos as GenreDaos;
use models\movie as Movie;
use models\genre as Genre;

class MovieDaos implements IDaos {

    const FILE_NAME = ROOT . "/data/movies.json";
    private $movies = array();

    public function __construct(){
        $this->retrieveData();
    }

    //return all movies from array
    public function getAll(){
        return $this->movies;
    }

    //return all movies from a genre
    public function getByGenre($genreId){
        $movies = array();
        foreach($this->movies as $movie){
            if(in_array($genreId, $movie->getGenresId())){
                $movies[] = $movie;
            }
        }
        return $movies;
    }

    //return all movies from a year
    public function getByYear($year){
        //TODO change this to something less awful, or just wait for sql...
        $movies = array();
        foreach($this->movies as $movie){
            $movieYear = explode('-', $movie->getReleaseDate())[0];
            if($movieYear == $year){
                $movies[] = $movie;
            }
        }
        return $movies;
    }

    public function add($movie){
        array_push($this->movies,$movie);
        $this->saveData();
    }

    //return true if movie exists in db, false if it doesn't
    public function exists($id){
        foreach($this->movies as $movie){
            if($movie->getId() == $id){
                return true;
            }
        }
        return false;
    }

    //save movie array to json file
    private function saveData(){
        $arrayToEncode = array();
        foreach($this->movies as $movie){
            $valuesArray['id'] = $movie->getId();
            $valuesArray['title'] = $movie->getTitle();
            $valuesArray['overview'] = $movie->getOverview();
            $valuesArray['img'] = $movie->getImg();
            $valuesArray['originalLanguage'] = $movie->getOriginalLanguage();
            $valuesArray['genresId'] = $movie->getGenresId();
            $valuesArray['releaseDate'] = $movie->getReleaseDate();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents(self::FILE_NAME, $jsonContent);
    }

    //load movie array from json file
    private function retrieveData(){
        if (file_exists(self::FILE_NAME)){
            $jsonContent = file_get_contents(self::FILE_NAME);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray){
                $movie = new Movie($valuesArray['id'], $valuesArray['title'], $valuesArray['overview'], $valuesArray['img'], $valuesArray['originalLanguage'], $valuesArray['genresId'], $valuesArray['releaseDate']);
                array_push($this->movies, $movie);
            }
        }
    }


    //return a movie by its id, null if it doens't exists
    public function getById($id){
        foreach($this->movies as $movie){
            if($movie->getId() == $id)
                return $movie;
        }
        return null;
    }

    //from here to end of file is all api related
    const API_ROOT_URL = "https://api.themoviedb.org/3/";
    const API_IMAGE_URL = "http://image.tmdb.org/t/p/w500";
    const API_DEFAULT_LANG = "es";

    public function updateFromAPI(){
         $page = 1;
        do{
            $moviesApi = $this->apiGetMovies($page);            
            foreach($moviesApi as $movie){
                if(!$this->exists($movie->getId())){
                    $this->add($movie);
                }
            }
            $page++;
        }while(!empty($moviesApi));
    }

    

    private function apiGetMovies($page = 1, $lang = self::API_DEFAULT_LANG){
        $url = self::API_ROOT_URL . "movie/now_playing?api_key=" . MOVIEDB_KEY . "&language=" . $lang . "&page=" . $page;
        $resultRaw = file_get_contents($url);
        $result = json_decode($resultRaw, true);   
        $movies = $result['results'];

        $resultMovies = array();
        foreach($movies as $jsonMovie){
            $movie = new Movie($jsonMovie['id'], $jsonMovie['original_title'], $jsonMovie['overview'], self::API_IMAGE_URL . $jsonMovie['poster_path'], $jsonMovie['original_language'], $jsonMovie['genre_ids'], $jsonMovie['release_date']);
            $resultMovies[] = $movie;
        }
        return $resultMovies;
    }


}

?>