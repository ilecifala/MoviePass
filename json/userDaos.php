<?php
namespace repository;
use daos\IDaos as IDaos;
use models\user as User;

class UserDaos implements IDaos {
    private $fileName;
    private $usersList = array();

    public function __construct(){
        $this->fileName = ROOT . '/data/users.json';
    }

    public function getById($id){
        foreach($this->usersList as $user){
            if($user->getId() == $id){
                return $user;
            }
        }
        return null;
    }

    public function getAll(){
        $this->retrieveData();
        return $this->usersList;
    }

    public function getOne($email){
        $this->retrieveData();
        foreach($this->usersList as $user){
            if($user->getEmail() == $email){
                return $user;
            }
        }
        return null;
    }

    public function add($user){
        $this->retrieveData();
        array_push($this->usersList,$user);
        $this->saveData();
    }

    public function exists($email){
        foreach($this->usersList as $user){
            if($user->getEmail() == $email){
                return true;
            }
        }
        return false;
    }

    private function saveData(){
        $arrayToEncode = array();
        foreach($this->usersList as $user){
            $valuesArray['id'] = $user->getId();
            $valuesArray['name'] = $user->getName();
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['password'] = $user->getPassword();
            $valuesArray['isAdmin'] = $user->isAdmin();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);

    }

    private function retrieveData(){
        $this->usersList = array();
        if (file_exists($this->fileName)){
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray){
                $user = new User();
                $user->setId($valuesArray['id']);
                $user->setName($valuesArray['name']);
                $user->setEmail($valuesArray['email']);
                $user->setPassword($valuesArray['password']);
                $user->setAdmin($valuesArray['isAdmin']);
                array_push($this->usersList, $user);
            }
        }
    }
}

?>