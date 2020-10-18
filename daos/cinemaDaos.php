<?php
namespace daos;
use daos\IDaos as IDaos;
use models\cinema as Cinema;

class CinemaDaos implements IDaos{
    private $connection;
    const TABLE_NAME = "cinemas";

    public function getAll(){
        try {
            $cinemaList = array ();
            $query = "SELECT * FROM ".self::TABLE_NAME.";";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->execute($query);

            foreach($resultSet as $row){
                $cinema = new Cinema();
                $cinema->setId($row['id_cinema']);
                $cinema->setName($row['name_cinema']);
                $cinema->setCapacity($row['capacity_cinema']);
                $cinema->setAdress($row['address_cinema']);
                $cinema->setCity($row['city_cinema']);
                $cinema->setZip($row['zip_cinema']);
                $cinema->setProvince($row['province_cinema']);
                $cinema->setTicketPrice($row['ticketPrice_cinema']);

                array_push($cinemaList, $cinema);
            }

            return $cinemaList;
        }
        catch(Exception $ex){
            throw $ex;
        }
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

    public function exists($id){
        try {
            $query = "SELECT * FROM ".self::TABLE_NAME. "where id_cinema = :id_cinema;";
            $this->connection = Connection::GetInstance();
            $parameters['id_cinema'] = $id;
            $resultSet = $this->connection->execute($query, $parameters);

            if(!empty($resultSet)){
                return true;
            } else {
                return false;
            }

        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function getById($id){
        
        try{
            $query = "SELECT * FROM".self::TABLE_NAME." where id_cinema = :id_cinema;";
            $this->connection = Connection::GetInstance();
            $parameters['id_cinema'] = $id;
            $resultSet = $this->connection->execute($query,$parameters);

            if (!empty($resultSet)){
                return $this->mapear($resultSet);
            } else {
                return false;
            }
            
        } catch (Exception $ex){
            throw $ex;
        }
    }

    private function mapear($value){
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $cinema = new Cinema();

            $cinema->setId($p['id_cinema']);
            $cinema->setName($p['name_cinema']);
            $cinema->setCapacity($p['capacity_cinema']);
            $cinema->setAddress($p['address_cinema']);
            $cinema->setCity($p['city_cinema']);
            $cinema->setProvince($p['province_cinema']);
            $cinema->setZip($p['zip_cinema']);
            $cinema->setTicketPrice($p['ticketPrice_cinema']);
            
            return $cinema;
        },$value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>