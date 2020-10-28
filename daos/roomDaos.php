<?php
namespace daos;
use models\room as Room;

class RoomDaos{

    const TABLE_NAME = "rooms";

    private static $instance = null;

    private $rooms = array();

    private function __construct(){
        $query = "SELECT * FROM " . self::TABLE_NAME;

        $connection = Connection::getInstance();

        $roomsArray = $connection->execute($query);

        foreach($roomsArray as $roomArray){
            $room = new Room($roomArray['name_room'], $roomArray['price_room'], $roomArray['capacity_room']);
            $room->setId($roomArray['id_room']);


            //$room->setShows(RoomDaos::getInstance()->getAll());
            //array_push($this->rooms[$roomArray['idCinema_room']], $room);
            $this->rooms[$roomArray['idCinema_room']][] = $room;
        }
    }

    public static function getInstance(){

        if(!self::$instance){
            self::$instance = new RoomDaos();
        }
        return self::$instance;
    }

    public function exists($id){
        foreach($this->rooms as $room){
            if($room->getId() == $id){
                return true;
            }
        }
        return false;
    }

    public function getById($id){
        if(isset($this->rooms[$id])){
            return $this->rooms[$id];
        }
        return array();
    }

    public function getByCinema($idCinema){
        $result = array();
        foreach($this->rooms as $room){

        }
    }

    public function add($room, $idCinema){
        try{
            //insert into db
            $query = "INSERT INTO " . self::TABLE_NAME. "
                                        (name_room, price_room, capacity_room, idCinema_room) VALUES
                                        (:name_room, :price_room, :capacity_room, :idCinema_room)";
 
            $params['name_room'] = $room->getName();
            $params['price_room'] = $room->getPrice();
            $params['capacity_room'] = $room->getCapacity();
            $params['idCinema_room'] = $idCinema;

            $this->connection = Connection::getInstance();
            $this->connection->ExecuteNonQuery($query, $params);
            
            $room->setId($this->connection->getlastId());
            //insert into array
            $roomArray['idCinema_room'][] = $room;

            return $room->getId();

        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function remove($id){
        
    }

    public function modify($room){        
        
    }
}
?>