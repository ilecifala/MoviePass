<?php
namespace daos;
use daos\baseDaos as BaseDaos;
use models\movie as Movie;

class MovieDaos extends BaseDaos{

    const TABLE_NAME = 'movies';

    public function __construct(){
        parent::__construct(self::TABLE_NAME, 'Movie'); 
        set_time_limit(0);       
    }

    public function getAll(){
        return parent::_getAll();
    }

    public function exists($id){
        return parent::_exists($id);
    }

    public function getById($id){
        return parent::_getByProperty($id, 'id');
    }

    public function add($movie){
        return parent::_add($movie, true);
    }

    public function getMoviesFilterGenreAndYear($genre, $year){
        //TODO
    }

    const API_ROOT_URL = "https://api.themoviedb.org/3/";
    const API_IMAGE_URL = "http://image.tmdb.org/t/p/w500";
    const API_DEFAULT_LANG = "es";
    public function update($lang = self::API_DEFAULT_LANG){
        $page = 1;
        do{
            $moviesApi = $this->updateFromApi($page);            
            foreach($moviesApi as $movie){
                if(!$this->exists($movie->getId())){
                    //get duration
                    $url = self::API_ROOT_URL . "movie/{$movie->getId()}}?api_key=" . MOVIEDB_KEY . "&language=$lang";
                    $resultRaw = file_get_contents($url);
                    $runtime = json_decode($resultRaw, true)['runtime'];
                    $movie->setDuration($runtime);
                    $this->add($movie);
                }
            }
            $page++;
        }while(!empty($moviesApi));
    }


    private function updateFromApi($page = 1, $lang = self::API_DEFAULT_LANG){
        $url = self::API_ROOT_URL . "movie/now_playing?api_key=" . MOVIEDB_KEY . "&language=" . $lang . "&page=" . $page;
        $resultRaw = file_get_contents($url);
        $result = json_decode($resultRaw, true);   
        $movies = $result['results'];

        $resultMovies = array();

        foreach($movies as $jsonMovie){
            $movie = new Movie($jsonMovie['id'], $jsonMovie['original_title'], $jsonMovie['overview'], self::API_IMAGE_URL . $jsonMovie['poster_path'], $jsonMovie['original_language'], serialize($jsonMovie['genre_ids']), $jsonMovie['release_date']);
            $resultMovies[] = $movie;
        }

        return $resultMovies;
    }
}
?>