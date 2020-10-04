<?php
namespace controllers;

use api\MovieDbInterface as api;

class HomeController{

    public function index(){
        echo "hey";
        //TODO mostrar peliculas
        $api = new api();
        $movies = $api->getMovies();

        var_dump($movies);
        //$api->getFullMovies();        
    }
}


?>