<?php
namespace daos;
use daos\baseDaos as BaseDaos;

class CinemaDaos extends BaseDaos{

    const TABLE_NAME = "cinemas";

    public function __construct(){
        parent::__construct(self::TABLE_NAME, 'Cinema');        
    }

    public function getAll(){
        return parent::_getAll();
    }

    public function exists($id){
        return parent::_exists($id);
    }

    public function getById($id){
        return parent::_getByProperty($id, 'id');
    }

    public function add($cinema){
        return parent::_add($cinema);
    }

    public function remove($id){
        return parent::_remove($id, 'id');
    }
}
?>