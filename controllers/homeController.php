<?php
namespace controllers;

class HomeController{

    public function index(){
        //echo "hey";
        //TODO mostrar peliculas
        //$api = new api();
        //$api->getFullMovies();  
        //include("views/index.php");

        header("Location: movie/show");
    }
}


?>