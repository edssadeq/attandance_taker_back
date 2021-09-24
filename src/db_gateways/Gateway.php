<?php


namespace src\db_gateways;


interface Gateway
{
    public function getAll();

    public function getOne($id);

    public function insert(Array $data);

    public function update($id, Array $data);

    public function delete($id);
}