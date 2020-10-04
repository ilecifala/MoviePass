<?php
namespace repository;

interface IRepository{
    public function getAll();
    public function add($user);
}
?>