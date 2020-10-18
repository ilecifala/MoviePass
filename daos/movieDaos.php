<?php
namespace daos;
use daos\IDaos as IDaos;
use models\movie as Movie;

class MovieDaos implements IDaos{
    private $connection;
    const TABLE_NAME = 'movies';

    public function getAll(){
        try{
            $movieList = array();
            $query = "SELECT * FROM ".self::TABLE_NAME;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->execute($query);

            foreach($resultSet as $row){
                $movie = new Movie();
                
                $movie->setId($row['id_movie']);
                $movie->setTitle($row['title_movie']);
                $movie->setOverview($row['overview_movie']);
                $movie->setImg($row['img_movie']);
                $movie->setOriginalLanguage($row['language_movie']);
                $movie->setGenresId($row['idsGenres_movie']);
                $movie->setReleaseDate($row['releaseDate_movie']);
                $movie->setDuration($row['duration_movie']);

                array_push($movieList, $movie);
            }

            return $userList;
    
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function add($movie){
        try{
            $query = "INSERT INTO ".self::TABLE_NAME." (title_movie, overview_movie, img_movie, language_movie, idsGenres_movie, releaseDate_movie, duration_movie) VALUES (:title_movie, :overview_movie, :img_movie, :language_movie, :idsGenres_movie, :releaseDate_movie, :duration_movie);";
            
            $parameters['title_movie'] = $movie->getTitle();
            $parameters['overview_movie'] = $movie->getOverview();
            $parameters['img_movie'] = $movie->getImg();
            $parameters['language_movie'] = $movie->getOriginalLanguage();
            $parameters['idsGenres_movie'] = $movie->getGenresId();
            $parameters['releaseDate_movie'] = $movie->getReleaseDate();
            $parameters['duration_movie'] = $movie->getDuration();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function exists($id){
        try {
            $query = "SELECT * FROM ".self::TABLE_NAME. "where id_movie = :id_movie;";
            $this->connection = Connection::GetInstance();
            $parameters['id_movie'] = $id;
            $resultSet = $this->connection->execute($query, $parameters);

            if(!empty($resultSet)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function getById($id){
        try{
            $query = "SELECT * FROM ".self::TABLE_NAME." where id_movie = :id_movie;";
            $this->connection = Connection::GetInstance();
            $parameters['id_movie'] = $id;
            $resultSet = $this->connection->execute($query, $parameters);

            if(!empty($resultSet)){
                return $this->mapear($resultSet);
            } else {
                return false;
            }

        } catch(Exception $ex){
            throw $ex;
        }
    }

    private function mapear($value){
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $movie = new Movie();
            
            $movie->setId($p['id_movie']);
            $movie->setTitle($p['title_movie']);
            $movie->setOverview($p['overview_movie']);
            $movie->setImg($p['img_movie']);
            $movie->setOriginalLanguage($p['language_movie']);
            $movie->setGenresId($p['idsGenres_movie']);
            $movie->setReleaseDate($p['releaseDate_movie']);
            $movie->setDuration($p['duration_movie']);

            return $movie;
        },$value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

}
?>