<?php


namespace src\db_gateways;


class CourseGW implements Gateway
{
    private $dbconnection = null;

    public function __construct($dbconnection)
    {
        $this->dbconnection = $dbconnection;
    }

    public function getAll(){
        $sql_query = "
            SELECT * FROM `course`
        ";
        try {
            $statement = $this->dbconnection->query($sql_query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getCoursesByParticipantID($id){
        $sql_query = "
        SELECT course.COURSE_ID, course.COURSE_NAME, course.COURSE_DESC, course.MEETS_NUMBER
        FROM course 
        INNER JOIN follow_course ON course.COURSE_ID = follow_course.COURSE_ID
        WHERE follow_course.PAR_ID = :PAR_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(":PAR_ID"=>$id));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    public function getOne($id){
        $sql_query = "
        SELECT * 
        FROM `course` 
        WHERE `COURSE_ID` = :COURSE_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(":COURSE_ID"=>$id));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }

    public function insert(Array $data){
        $sql_query = "
            INSERT INTO `course`( `COURSE_NAME`, `COURSE_DESC`, `MEETS_NUMBER`) 
            VALUES (:COURSE_NAME, :COURSE_DESC, :MEETS_NUMBER)
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':COURSE_NAME'=>$data['COURSE_NAME'],
                ':COURSE_DESC'=>$data['COURSE_DESC'],
                ':MEETS_NUMBER'=>$data['MEETS_NUMBER']
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }

    public function update($id, Array $data){
        $sql_query = "
            UPDATE `course` 
            SET 
                `COURSE_NAME`= :COURSE_NAME,
                `COURSE_DESC`= :COURSE_DESC,
                `MEETS_NUMBER`= :MEETS_NUMBER 
            WHERE `COURSE_ID`= :COURSE_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':COURSE_ID' => $id,
                ':COURSE_NAME'=>$data['COURSE_NAME'],
                ':COURSE_DESC'=>$data['COURSE_DESC'],
                ':MEETS_NUMBER'=>$data['MEETS_NUMBER']
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    public function delete($id){
        $sql_query = "
            DELETE FROM `course`
            WHERE `COURSE_ID`= :COURSE_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':COURSE_ID' => $id
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }
}