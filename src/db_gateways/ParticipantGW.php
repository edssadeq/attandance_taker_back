<?php


namespace src\db_gateways;

class ParticipantGW implements Gateway
{

    private $dbconnection = null;

    public function __construct($dbconnection)
    {
        $this->dbconnection = $dbconnection;
    }

    public function getAll(){
        $sql_query = "
            SELECT * FROM `participant`
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
        FROM `participant`
        WHERE `PAR_ID`= :PAR_ID
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

    public function getParticipantsByMeetID($id){
        $sql_query = "
        SELECT participant.PAR_ID, 
              participant.PAR_FNAME,
              participant.PAR_LNAME,      
              participant.PAR_EMAIL
        FROM participant
        INNER JOIN participate_meet 
        ON participate_meet.PAR_ID = participant.PAR_ID
        WHERE participate_meet.MEET_ID = :MEET_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(":MEET_ID"=>$id));
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }

    public function getParticipantsByCourseID($id){
        $sql_query = "
        SELECT participant.PAR_ID, 
              participant.PAR_FNAME,
              participant.PAR_LNAME,      
              participant.PAR_EMAIL
        FROM participant
        INNER JOIN follow_course 
        ON follow_course.PAR_ID = participant.PAR_ID
        WHERE follow_course.COURSE_ID = :COURSE_ID
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

    public function insert(Array $participant_data){
        $sql_query = "
            INSERT INTO `participant`(`PAR_FNAME`, `PAR_LNAME`, `PAR_EMAIL`) 
            VALUES ( :par_fname, :par_lname, :par_email)
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                                ':par_fname'=>$participant_data['PAR_FNAME'],
                                ':par_lname'=>$participant_data['PAR_LNAME'],
                                ':par_email'=>$participant_data['PAR_EMAIL']
                                ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }

    }

    public function update($id, Array $participant_data){
        $sql_query = "
            UPDATE `participant` 
            SET `PAR_FNAME`= :PAR_FNAME ,
                `PAR_LNAME`= :PAR_LNAME,
                `PAR_EMAIL`= :PAR_EMAIL
            WHERE `PAR_ID` = :PAR_ID
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':PAR_ID' => $id,
                ':PAR_FNAME'=>$participant_data['PAR_FNAME'],
                ':PAR_LNAME'=>$participant_data['PAR_LNAME'],
                ':PAR_EMAIL'=>$participant_data['PAR_EMAIL']
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
            DELETE FROM `participant` 
            WHERE PAR_ID = :id 
        ";

        try {
            $statment = $this->dbconnection->prepare($sql_query);
            $statment->execute(array(
                ':id' => $id
            ));
            $result = $statment->rowCount();
            return $result;
        }
        catch (\PDOException $e){
            exit($e->getMessage());
        }
    }
}