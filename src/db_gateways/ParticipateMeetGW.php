<?php


namespace src\db_gateways;


class ParticipateMeetGW implements Gateway
{
    private $dbconnection = null;

    public function __construct($dbconnection)
    {
        $this->dbconnection = $dbconnection;
    }

    public function getAll()
    {
        $sql_query = "
        SELECT * FROM `participate_meet`
        ";

        try {
            $statement = $this->dbconnection->query($sql_query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getOne($id)
    {
        /*
         * $id array par_id and meet_id
         */
        $sql_query = "
        SELECT * 
        FROM `participate_meet`
        WHERE `PAR_ID`= :PAR_ID AND `MEET_ID`= :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(":PAR_ID"=>$id["PAR_ID"], ":MEET_ID"=>$id['MEET_ID']));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    public function insert(array $data)
    {
        $sql_query = "
            INSERT INTO `participate_meet`(`PAR_ID`, `MEET_ID`) 
            VALUES (:PAR_ID,:MEET_ID)
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID'=>$data['PAR_ID'],
                ':MEET_ID'=>$data['MEET_ID']
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $sql_query = "
            DELETE FROM `participate_meet` 
            WHERE `PAR_ID` = :PAR_ID AND `MEET_ID`= :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID' => $id['PAR_ID'],
                ':MEET_ID' => $id['MEET_ID']
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }
}