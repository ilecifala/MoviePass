<?php
namespace daos;
use daos\IDaos as IDaos;
use models\user as User;

class UserDaos implements IDaos{
    private $connection;
    const TABLE_NAME = 'users';

    public function getAll(){
        try{
            $userList = array();
            $query = "SELECT * FROM ".self::TABLE_NAME;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->execute($query);

            foreach($resultSet as $row){
                $user = new User();
                
                $user->setId($row['id_user']);
                $user->setFirstName($row['firstName_user']);
                $user->setLastName($row['lastName_user']);
                $user->setEmail($row['email_user']);
                $user->setPassword($row['password_user']);
                $user->setDni($row['dni_user']);
                $user->setIdRol($row['id_rol']);

                array_push($userList, $user);
            }

            return $userList;
    
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function add($user){
        try{
            $query = "INSERT INTO ".self::TABLE_NAME." (email_user, password_user, lastName_user, firstName_user, dni_user, id_rol) VALUES (:email_user, :password_user, :lastName_user, :firstName_user, :dni_user, :id_rol);";
            
            $parameters['email_user'] = $user->getEmail();
            $parameters['password_user'] = $user->getPassword();
            $parameters['lastName_user'] = $user->getLastName();
            $parameters['firstName_user'] = $user->getFirstName();
            $parameters['dni_user'] = $user->getDni();
            $parameters['id_rol'] = $user->getIdRol();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch(Exception $ex){
            throw $ex;
        }
    }

    public function exists($email){
        try {
            $query = "SELECT * FROM ".self::TABLE_NAME. "where email_user = :email_user;";
            $this->connection = Connection::GetInstance();
            $parameters['email_user'] = $email;
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
            $query = "SELECT * FROM ".self::TABLE_NAME." where id_user = :id_user;";
            $this->connection = Connection::GetInstance();
            $parameters['id_user'] = $id;
            $resultSet = $this->connection->execute($query, $parameters);
            if(!empty($resultSet)){
                return $this->mapear($resultSet);
            } else {
                return false;
            }

        } catch(Exception $ex){
            throw $ex;
        }
    }

    private function mapear($value){
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $user = new User();
            
            $user->setId($p['id_user']);
            $user->setFirstName($p['firstName_user']);
            $user->setLastName($p['lastName_user']);
            $user->setEmail($p['email_user']);
            $user->setPassword($p['password_user']);
            $user->setDni($p['dni_user']);
            $user->setIdRol($p['id_rol']);

            return $user;
        },$value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

}
?>