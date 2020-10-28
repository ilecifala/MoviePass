<?php
namespace daos;
use models\cinema as Cinema;


class CinemaDaos{

    private static $instance = null;
    private $cinemas = array();
    const TABLE_NAME = "cinemas";

    private function __construct(){        
        $query = "SELECT * FROM " . self::TABLE_NAME;

        $connection = Connection::getInstance();

        $cinemasArray = $connection->execute($query);

        foreach($cinemasArray as $cinemaArray){
            $cinema = new Cinema($cinemaArray['name_cinema'], $cinemaArray['address_cinema'], $cinemaArray['city_cinema'], $cinemaArray['zip_cinema'], $cinemaArray['province_cinema']);
            $cinema->setId($cinemaArray['id_cinema']);


            //Y dentro del daos de salas se tendría que llamar al daos de funciones para llenar cada sala con las funciones que tenga,
            //y dentro del de funciones al de peliculas y dentro del de peliculas al de genero
            $cinema->setRooms(RoomDaos::getInstance()->getById($cinemaArray['id_cinema']));

            array_push($this->cinemas, $cinema);
        }
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new CinemaDaos();
        }
        return self::$instance;
    }

    public function getAll(){
        return $this->cinemas;        
    }

    public function getById($id){
        foreach($this->cinemas as $cinema){
            if($cinema->getId() == $id){
                return $cinema;
            }
        }
        return null;
    }

    public function add($cinema){
        try{
            //insert into db
            $query = "INSERT INTO " . self::TABLE_NAME. "
                                        (name_cinema, address_cinema, city_cinema, zip_cinema, province_cinema) VALUES
                                        (:name_cinema, :address_cinema, :city_cinema, :zip_cinema, :province_cinema)";
 
            $params['name_cinema'] = $cinema->getName();
            $params['address_cinema'] = $cinema->getaddress();
            $params['city_cinema'] = $cinema->getCity();
            $params['zip_cinema'] = $cinema->getZip();
            $params['province_cinema'] = $cinema->getProvince();

            $this->connection = Connection::getInstance();
            $this->connection->ExecuteNonQuery($query, $params);
            
            $cinema->setId($this->connection->getlastId());
            //insert into array
            array_push($this->cinemas, $cinema);

        } catch (\Exception $ex){
            throw $ex;
        }
    }

    
    public function exists($id){

        foreach($this->cinemas as $cinema){
            if($cinema->getId() == $id){
                return true;
            }
        }
        return false;
        
    }

    public function remove($id){

        foreach($this->cinemas as $index => $cinema){            
            if($cinema->getId() == $id){
                try{
                    //remove from db
                    $query = "DELETE FROM " . self::TABLE_NAME . " WHERE id_cinema = :id_cinema";
                    $this->connection = Connection::getInstance();
                    $parameters["id_cinema"] = $id;
                    $result = $this->connection->executeNonQuery($query, $parameters);

                    //remove from array
                    unset($this->cinemas[$index]);                    
        
                } catch (\Exception $ex){
                    throw $ex;
                }
            }
        }
        
    }

    public function modify($_cinema){
        foreach($this->cinemas as $index => $cinema){            
            if($cinema->getId() == $_cinema->getId()){

                $query = "UPDATE " . self::TABLE_NAME . " SET
                                                name_cinema = :name_cinema,
                                                address_cinema = :address_cinema,
                                                city_cinema = :city_cinema,
                                                province_cinema = :province_cinema,
                                                zip_cinema = :zip_cinema
                                                WHERE id_cinema = :id_cinema";

                $params['id_cinema'] = $_cinema->getId();
                $params['name_cinema'] = $_cinema->getName();
                $params['address_cinema'] = $_cinema->getaddress();
                $params['city_cinema'] = $_cinema->getCity();
                $params['province_cinema'] = $_cinema->getProvince();
                $params['zip_cinema'] = $_cinema->getZip();


                $this->connection = Connection::getInstance();
                $this->connection->ExecuteNonQuery($query, $params);

                //update array
                $this->cinemas[$index] = $_cinema;

            }
        }
    }

    public function getAllWithRooms(){

        $result = array();
        foreach($this->cinemas as $cinema){
            if(!empty($cinema->getRooms())){
                array_push($result, $cinema);
            }
        }
    }

    public function addRoom($room, $idCinema){
        //add it to db
        $generatedId = RoomDaos::getInstance()->add($room, $idCinema);

        $room->setId($generatedId);
        foreach($this->cinemas as $cinema){
            if($cinema->getId() == $idCinema){
                $cinema->getRooms()[] = $room;
            }
        }
    }
}
?>