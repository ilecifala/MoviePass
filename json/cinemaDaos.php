<?php
namespace repository;
use daos\IDaos as IDaos;
use models\cinema as Cinema;

class CinemaDaos implements IDaos{

    const FILE_NAME = ROOT . "/data/cinemas.json";

    private $cinemas = array();

    public function __construct(){
        $this->retrieveData();        
    }

    public function getAll(){
        return $this->cinemas;
    }

    public function add($cinema){
        array_push($this->cinemas,$cinema);
        $this->saveData();
    }

    public function exists($id){
        foreach($this->cinemas as $cinema){
            if($cinema->getId() == $id){
                return true;
            }
        }
        return false;
    }

    public function getById($id){
        foreach($this->cinemas as $cinema){
            if($cinema->getId() == $id)
                return $cinema;
        }
        return null;
    }

    public function remove($id){
        foreach($this->cinemas as $i => $cinema){
            if($cinema->getId() == $id){
                unset($this->cinemas[$i]);
                $this->saveData();
                return true;
            }
        }
        return false;
    }

    public function modify($cinema){

        foreach($this->cinemas as $i => $c){
            if($c->getId() == $cinema->getId()){
                $this->cinemas[$i] = $cinema;
                $this->saveData();
                return true;
            }
        }
        return false;
    }

    private function saveData(){
        $arrayToEncode = array();
        foreach($this->cinemas as $cinema){
            $valuesArray['id'] = $cinema->getId();
            $valuesArray['name'] = $cinema->getName();
            $valuesArray['capacity'] = $cinema->getCapacity();
            $valuesArray['address1'] = $cinema->getAddress1();
            $valuesArray['address2'] = $cinema->getAddress2();
            $valuesArray['city'] = $cinema->getCity();
            $valuesArray['postal'] = $cinema->getPostal();
            $valuesArray['province'] = $cinema->getProvince();
            $valuesArray['ticketPrice'] = $cinema->getTicketPrice();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents(self::FILE_NAME, $jsonContent);
    }

    private function retrieveData(){
        if (file_exists(self::FILE_NAME)){
            $jsonContent = file_get_contents(self::FILE_NAME);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray){
                $cinema = new Cinema($valuesArray['name'], $valuesArray['capacity'], $valuesArray['address1'],$valuesArray['address2'],$valuesArray['city'],$valuesArray['postal'],$valuesArray['province'], $valuesArray['ticketPrice']);
                $cinema->setId($valuesArray['id']);
                array_push($this->cinemas, $cinema);
            }
        }
    }

}


?>