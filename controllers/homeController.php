<?php
namespace controllers;

use daos\roomDaos as RoomDaos;
use daos\cinemaDaos as CinemaDaos;

use models\room as Room;
use daos\BaseDaos as BaseDaos;

class HomeController{

    public function index(){

        //header("Location: movie/displayBillboard");

        echo '<pre>';
        var_dump(CinemaDaos::getInstance()->getAll());
        echo '</pre>';

        CinemaDaos::getInstance()->addRoom(new Room(), 1);

    }
}


?>