<?php
namespace models;


class Show{
    private $id;
    //Estos dos se llaman id pero en realidad es el objeto
    private $idMovie;
    private $idRoom;
    private $datetime;

    public function __construct($movie, $room, $date){

        $this->movie = $movie;
        $this->room = $room;
        $this->date = $date;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getIdMovie(){
        return $this->movie;
    }

    public function setIdMovie($movie){
        $this->movie = $movie;
    }

    public function getIdRoom(){
        return $this->room;
    }

    public function setIdRoom($room){
        $this->room = $room;
    }

    public function getDatetime(){
        return $this->date;
    }

    public function setDatetime($date){
        $this->date = $date;
    }
}



?>