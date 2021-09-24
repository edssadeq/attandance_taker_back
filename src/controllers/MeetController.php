<?php


namespace src\controllers;
use src\db_gateways\MeetGW;
use src\db_gateways\ParticipantGW;
use src\db_gateways\CourseGW;

class MeetController extends ControllerAbstract
{
    private $meetGateway;
    private $participantGateway;
    private $courseGateway;

    public function __construct($db, $requestMethod, $id)
    {
        parent::__construct($db, $requestMethod, $id);
        $this->meetGateway = new MeetGW($db);
        $this->participantGateway = new ParticipantGW($db);
        $this->courseGateway = new CourseGW($db);
    }

    protected function getALl()
    {
        $result = $this->meetGateway->getAll();
        return $this->setupSuccessResponse($result);
    }

    protected function getAllByParticipant($par_id){
        $result = $this->participantGateway->getOne($par_id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $result = $this->meetGateway->getMeetsByParticipantID($par_id);
        return $this->setupSuccessResponse($result);
    }

    protected function getAllByCourse($id){
        $result = $this->courseGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $result = $this->meetGateway->getMeetsByCourseID($id);
        return $this->setupSuccessResponse($result);
    }

    protected function getOneById($id)
    {
        $result = $this->meetGateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        return $this->setupSuccessResponse($result);
    }

    protected function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateMeet($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->meetGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    protected function update($id)
    {
        $result = $this->meetGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        //php://input is a read-only stream that allows you to read raw data from the request body.
        // php://input is not available with enctype="multipart/form-data".
        if (! $this->validateMeet($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->meetGateway->update($id, $input);

        return $this->setupSuccessResponse(null);
    }

    protected function delete($id)
    {
        $result = $this->meetGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->meetGateway->delete($id);
        return $this->setupSuccessResponse(null);
    }



    private function validateMeet($input){
        /*
            COURSE_ID
            MEET_DATE_TIME
            PAR_NUMBER
            MEET_ORGANISER
            MEET_NOTES
         */
        if(!isset($input['MEET_ID']) || !isset($input['MEET_DATE_TIME'])){
            return false;
        }
        return true;


    }

    protected function getAllByMeet($id)
    {
        // TODO: Implement getAllByMeet() method.
        return $this->notFoundResponse();
    }
}

