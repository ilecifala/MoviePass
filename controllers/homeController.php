<?php
namespace controllers;

class HomeController{

    public function index(){

        header("Location: movie/show");
    }
}


?>