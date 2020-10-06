<?php
namespace repository;

interface IRepository{
    public function getAll();
    public function add($object);
    public function exists($value);
    public function getById($id);
}
?>