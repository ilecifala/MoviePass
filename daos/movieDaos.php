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
        $query = "INSERT INTO " . self::TABLE_NAME . " (id_movie, title_movie, overview_movie, img_movie, language_movie, releaseDate_movie, duration_movie) values(:id_movie, :title_movie, :overview_movie, :img_movie, :language_movie, :releaseDate_movie, :duration_movie);";

        $params['id_movie'] = $movie->getId();
        $params['title_movie'] = $movie->getTitle();
        $params['overview_movie'] = $movie->getOverview();
        $params['img_movie'] = $movie->getImg();
        $params['language_movie'] = $movie->getLanguage();
        $params['releaseDate_movie'] = $movie->getReleaseDate();
        $params['duration_movie'] = $movie->getDuration();

        $this->connection = Connection::getInstance();
        
        
    }

    public function getMoviesFiltered($genre, $year, $name, $limit){
        $query ="SELECT m.* from movies m LEFT JOIN movies_genres mg ON m.id_movie = mg.id_movie LEFT JOIN genres g ON mg.id_genre = g.id_genre";
        $params = array();
        $f = false;
        if($genre != "all" | $year != "all" | !empty($name)){
            $query .= " WHERE ";
        }
        
        if($genre != "all"){
            $query .= " g.id_genre = :genre";
            $params['genre'] = $genre;
            $f = true;
            
        }

        if($year != "all"){
            if($f){
                $query .= " and ";
            }
            $params['year'] = $year;
            $query .= " year(releaseDate_movie) = :year";
            $f = true;            
        }

        if(!empty($name)){
            if($f){
                $query .= " and ";
            }
            $params['name'] = $name;
            $query .= " m.title_movie LIKE CONCAT('%',CONCAT(:name, '%'))";
            $f = true;            
        }
        
        $offset = 16;
        $query .= " GROUP BY m.id_movie";

        $query .= " limit 0, " . $limit * $offset;
        //echo $query;

        



        $this->connection = Connection::getInstance();
        
        return $this->connection->executeWithAssoc($query, $params);
        
    }

    public function getMoviesYear(){
        $query = "SELECT YEAR(releaseDate_movie) as year FROM ". self::TABLE_NAME . " GROUP BY YEAR(releaseDate_movie)";     

        $connection = Connection::getInstance();
        
        return $this->connection->executeWithAssoc($query);
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

                    //instancia de connection
                    $this->connection = Connection::getInstance();
                    
                    //llenar movies_genres
                    $genres = $movie->getGenres();
                    foreach($genres as $genre){
                        $query = "INSERT INTO movies_genres (id_movie, id_genre) VALUES(:id_movie,:id_genre);";
                        $params['id_movie'] = $movie->getId();
                        $params['id_genre'] = $genre;
                        //ejecutar query
                        $this->connection->executeNonQuery($query, $params);
                    }
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
            $movie = new Movie($jsonMovie['id'], $jsonMovie['original_title'], $jsonMovie['overview'], self::API_IMAGE_URL . $jsonMovie['poster_path'], $jsonMovie['original_language'], $jsonMovie['genre_ids'], $jsonMovie['release_date']);

            $resultMovies[] = $movie;
        }

        return $resultMovies;
    }
}
?>