<?php
namespace daos;
use models\genre as Genre;

class GenreDaos implements IDaos{

    const FILE_NAME = ROOT . "/data/genres.json";

    private $genres = array();

    public function __construct(){
        $this->retrieveData();        
    }


    public function getAll(){
        return $this->genres;
    }

    public function add($genre){
        array_push($this->genres,$genre);
        $this->saveData();
    }

    public function exists($id){
        foreach($this->genres as $genre){
            if($genre->getId() == $id){
                return true;
            }
        }
        return false;

    }

    public function getById($id){
        foreach($this->genres as $genre){
            if($genre->getId() == $id)
                return $genre;
        }
        return null;
    }

    private function saveData(){
        $arrayToEncode = array();
        foreach($this->genres as $genre){
            $valuesArray['id'] = $genre->getId();
            $valuesArray['name'] = $genre->getName();
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
                $genre = new Genre($valuesArray['id'], $valuesArray['name']);
                array_push($this->genres, $genre);
            }
        }
    }

    //api related from here to bottom
    const API_ROOT_URL = "https://api.themoviedb.org/3/";
    const API_DEFAULT_LANG = "es";

    public function updateFromAPI($lang = self::API_DEFAULT_LANG){
        $url = self::API_ROOT_URL . "genre/movie/list?api_key=" . MOVIEDB_KEY . "&language=" . $lang;
        $resultRaw = file_get_contents($url);
        $result = json_decode($resultRaw, true);   
        $genres = $result['genres'];

        foreach($genres as $genre){
            $resultGenres[] = new Genre($genre['id'], $genre['name']);
        }
        $this->genres = $resultGenres;
        $this->saveData();
    }
    



}








?>