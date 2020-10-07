<?php
namespace repository;
use repository\IRepository as IRepository;
use models\movie as Movie;

use models\genre as Genre;

class MovieRepository implements IRepository {

    const FILE_NAME = ROOT . "/data/movies.json";
    private $movies = array();

    public function __construct(){
        $this->retrieveData();        
    }

    public function getAll(){
        return $this->movies;
    }

    public function getByGenre($genreId){
        $movies = array();
        foreach($this->movies as $movie){
            if(in_array($genreId, $movie->getGenresId())){
                $movies[] = $movie;
            }
        }
        return $movies;
    }

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

    public function exists($id){
        foreach($this->movies as $movie){
            if($movie->getId() == $id){
                return true;
            }
        }
        return false;
    }


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


    //TODO maybe move to its own repo?

    const GENRES_FILE = ROOT . "/data/genres.json";

    public function updateGenres($genres){
        $arrayToEncode = array();
        foreach($genres as $genre){
            $valuesArray['id'] = $genre->getId();
            $valuesArray['name'] = $genre->getName();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents(self::GENRES_FILE, $jsonContent);
    }

    public function getById($id){
        foreach($this->movies as $movie){
            if($movie->getId() == $id)
                return $movie;
        }
    }


}

?>