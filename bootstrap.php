<?php

require_once __DIR__.'/vendor/autoload.php';
use Dotenv\Dotenv as Dotenv;
use src\database\DbConnector  as Db;

//load the environment variables

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


//load the database connection
$dbconnction = (new Db())->getConnction();