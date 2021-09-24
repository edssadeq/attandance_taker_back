<?php


namespace src\db_gateways;


class FollowCourseGW implements Gateway
{

    private $dbconnection = null;

    public function __construct($dbconnection)
    {
        $this->dbconnection = $dbconnection;
    }

    public function getAll()
    {
        $sql_query = "
        SELECT * FROM `follow_course`
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
         * $id array par_id and course_id
         */
        $sql_query = "
        SELECT * 
        FROM `follow_course`
        WHERE `PAR_ID`= :PAR_ID AND  `COURSE_ID` = :COURSE_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ":PAR_ID" => $id["PAR_ID"],
                ":COURSE_ID" => $id['COURSE_ID']));
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
            INSERT INTO `follow_course`(`PAR_ID`, `COURSE_ID`) 
            VALUES (:PAR_ID,:COURSE_ID)
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID'=>$data['PAR_ID'],
                ':COURSE_ID'=>$data['COURSE_ID']
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
            DELETE FROM `follow_course` 
            WHERE `PAR_ID` = :PAR_ID AND `COURSE_ID`= :COURSE_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID' => $id['PAR_ID'],
                ':COURSE_ID' => $id['COURSE_ID']
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }
}