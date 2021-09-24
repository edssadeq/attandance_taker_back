<?php


namespace src\database;
require_once __DIR__."/../../vendor/autoload.php";
use \PDO;
use \PDOException;

class DbConnector
{
    private $dbconnection = null;

    public function __construct()
    {
        $db_host = $_ENV['DB_HOST'];
        $db_port = $_ENV['DB_PORT'];
        $db_name = $_ENV['DB_NAME'];
        $db_user = $_ENV['DB_USER'];
        $db_password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name";
        try {
            $this->dbconnection = new PDO(
                $dsn,
                $db_user,
                $db_password
            );
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getConnction(){
        return $this->dbconnection;
    }
}