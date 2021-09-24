<?php


namespace src\db_gateways;


class MeetGW implements Gateway
{
    private \PDO|null $dbconnection = null;

    public function __construct($dbconnection)
    {
        $this->dbconnection = $dbconnection;
    }

    public function getAll(){
        $sql_query = "
            SELECT * FROM `meet`
        ";
        try {
            $statement = $this->dbconnection->query($sql_query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getOne($id){
        $sql_query = "
        SELECT * 
        FROM `meet` 
        WHERE `MEET_ID` = :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->bindParam(':MEET_ID', $id);
            $statment->execute();
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }

    public function insert(Array $data){
        $sql_query = "
            INSERT INTO `meet`( `MEET_ID`,`COURSE_ID`, `MEET_DATE_TIME`, `PAR_NUMBER`, `MEET_ORGANISER`, `MEET_NOTES`) 
            VALUES (:MEET_ID, :COURSE_ID, :MEET_DATE_TIME , :PAR_NUMBER, :MEET_ORGANISER, :MEET_NOTES)
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':MEET_ID' => $data['MEET_ID'],
                ':COURSE_ID'=>$data['COURSE_ID'],
                ':MEET_DATE_TIME'=>$data['MEET_DATE_TIME'],
                ':PAR_NUMBER'=>$data['PAR_NUMBER'],
                ':MEET_ORGANISER'=>$data['MEET_ORGANISER'],
                ':MEET_NOTES'=>$data['MEET_NOTES'],
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
            UPDATE `meet` 
            SET `COURSE_ID`= :COURSE_ID,
                `MEET_DATE_TIME`= :MEET_DATE_TIME,
                `PAR_NUMBER`= :PAR_NUMBER,
                `MEET_ORGANISER`= :MEET_ORGANISER,
                `MEET_NOTES`= :MEET_NOTES
            WHERE `MEET_ID`= :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':MEET_ID' => $id,
                ':COURSE_ID'=>$data['COURSE_ID'],
                ':MEET_DATE_TIME'=>$data['MEET_DATE_TIME'],
                ':PAR_NUMBER'=>$data['PAR_NUMBER'],
                ':MEET_ORGANISER'=>$data['MEET_ORGANISER'],
                ':MEET_NOTES'=>$data['MEET_NOTES']
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
            DELETE FROM `meet` 
            WHERE `MEET_ID`= :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':MEET_ID' => $id
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    //get mmets by participant id
    public function getMeetsByParticipantID($par_id){
        $sql_query = "
            SELECT meet.`MEET_ID`, meet.`COURSE_ID`, meet.`MEET_DATE_TIME`,`PAR_NUMBER`,`MEET_ORGANISER`,`MEET_NOTES`
            FROM meet
            INNER JOIN participate_meet ON meet.MEET_ID = participate_meet.MEET_ID
            WHERE participate_meet.PAR_ID = :PAR_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID'=>$par_id
            ));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }

    //get meets by course id
    public function getMeetsByCourseID($course_id){
        $sql_query = "
            SELECT * FROM `meet` WHERE meet.COURSE_ID= :COURSE_ID 
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':COURSE_ID'=>$course_id
            ));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }
}