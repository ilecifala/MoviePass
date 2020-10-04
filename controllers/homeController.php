<?php
namespace controllers;

use api\MovieDbInterface as api;

class HomeController{

    public function index(){
        echo "hey";
        //TODO mostrar peliculas
        $api = new api();
        //$api->getMovies(1);
        $api->getFullMovies();        
    }
}


?>