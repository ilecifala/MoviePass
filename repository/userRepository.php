<?php
namespace repository;
use repository\IRepository as IRepository;
use models\user as User;

class UserRepository implements IRepository {
    private $fileName;
    private $usersList = array();

    public function __construct(){
        $this->fileName = ROOT . '/data/users.json';
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

    private function saveData(){
        $arrayToEncode = array();
        foreach($this->usersList as $user){
            $valuesArray['id'] = $user->getId();
            $valuesArray['name'] = $user->getName();
            $valuesArray['email'] = $user->getEmail();
            $valuesArray['password'] = $user->getPassword();
            $valuesArray['isAdmin'] = $user->getIsAdmin();
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
                $user->setIsAdmin($valuesArray['isAdmin']);
                array_push($this->usersList, $user);
            }
        }
    }
}

?>