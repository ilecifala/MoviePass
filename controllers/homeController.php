<?php
namespace controllers;

use models\cinema as Cinema;
use models\genre as Genre;
use daos\cinemaDaos as CinemaDaos;

use daos\BaseDaos as BaseDaos;

class HomeController{

    public function index(){

        header("Location: movie/show");
        //header("Location: movie/update");
        //$cinema1 = new Cinema('dddd', 20, 'Bolivar 1322', 'asdasd', 'asdasd', '1231', 120);
        //$cinemaDao = new CinemaDaos();
        //$cinemaDao->add($cinema1);
        

    }
}


?>