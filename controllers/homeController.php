<?php
namespace controllers;

use models\cinema as Cinema;
use daos\cinemaDaos as CinemaDao;

class HomeController{

    public function index(){

        //header("Location: movie/show");
        $cinema1 = new Cinema('asddasd', 20, 'Bolivar 1322', 'asdasd', 'asdasd', '1231', 120);
        $cinemaDao = new CinemaDao();
        $cinemaDao->add($cinema1);
    }
}


?>