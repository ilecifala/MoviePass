<?php
namespace daos;

interface IDaos{
    public function getAll();
    public function add($object);
    public function exists($value);
    public function getById($id);
}
?>