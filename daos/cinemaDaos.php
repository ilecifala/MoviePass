<?php
namespace daos;
use daos\IDaos as IDaos;
use models\cinema as Cinema;

class CinemaDaos implements IDaos{
    private $connection;
    const TABLE_NAME = "cinemas";

    public function getAll(){
        
    }

    public function add($cinema){
        try
            {
                $query = "INSERT INTO ".self::TABLE_NAME." (name_cinema, capacity_cinema, address_cinema, city_cinema, province_cinema, zip_cinema, ticketPrice_cinema) VALUES (:name_cinema, :capacity_cinema, :address_cinema, :city_cinema, :province_cinema, :zip_cinema, :ticketPrice_cinema);";
                
                $parameters["name_cinema"] = $cinema->getName();
                $parameters["capacity_cinema"] = $cinema->getCapacity();
                $parameters["address_cinema"] = $cinema->getAddress();
                $parameters["city_cinema"] = $cinema->getCity();
                $parameters["province_cinema"] = $cinema->getProvince();
                $parameters["zip_cinema"] = $cinema->getZip();
                $parameters["ticketPrice_cinema"] = $cinema->getTicketPrice();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
    }

    public function exists($value){

    }

    public function getById($id){

    }
}

?>