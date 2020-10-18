<?php
namespace daos;
use daos\IDaos as IDaos;
use models\genre as Genre;

class GenreDaos implements IDaos{
    private $connection;
    const TABLE_NAME = 'genres';

    public function getAll(){
        try{
            $genreList = array();
            $query = "SELECT * FROM ".self::TABLE_NAME;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->execute($query);

            foreach($resultSet as $row){
                $genre = new Genre();
                $genre->setId($row['id_genre']);
                $genre->setName($row['name_genre']);

                array_push($genreList, $genre);
            }

            return $genreList;
    
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function add($genre){
        try{
            $query = "INSERT INTO ".self::TABLE_NAME." (name_genre) VALUES (:name_genre);";
            $parameters['name_genre'] = $genre->getName();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function exists($name){
        try {
            $query = "SELECT * FROM ".self::TABLE_NAME. "where name_genre = :name_genre;";
            $this->connection = Connection::GetInstance();
            $parameters['name_genre'] = $name;
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
            $query = "SELECT * FROM ".self::TABLE_NAME." where id_genre = :id_genre;";
            $this->connection = Connection::GetInstance();
            $parameters['id_genre'] = $id;
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
            $genre = new Genre();
            $genre->setId($p['id_genre']);
            $genre->setName($p['name_genre']);
            return $genre;
        },$value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

}

?>