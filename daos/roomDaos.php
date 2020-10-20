<?php
namespace daos;
use daos\baseDaos as BaseDaos;

class RoomDaos extends BaseDaos{

    const TABLE_NAME = "rooms";

    public function __construct(){
        parent::__construct(self::TABLE_NAME, 'Room');        
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

    public function getByCinema($idCinema){
        return parent::_getAllByProperty($idCinema, 'idCinema');
    }

    public function add($room){
        return parent::_add($room);
    }

    public function remove($id){
        return parent::_remove($id, 'id');
    }

    public function modify($room){
        return parent::_modify($room, $room->getId(), "id");
    }
}
?>