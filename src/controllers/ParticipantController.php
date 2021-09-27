<?php


namespace src\controllers;
use src\db_gateways\ParticipantGW;
use src\db_gateways\MeetGW;
use src\db_gateways\CourseGW;

class ParticipantController extends ControllerAbstract
{
    private $participant_gateway;
    private $meet_gateway;
    private $course_gateway;

    public function __construct($db, $requestMethod, $par_id)
    {
        parent::__construct($db, $requestMethod, $par_id);

        $this->participant_gateway = new ParticipantGW($db);
        $this->meet_gateway = new MeetGW($db);
        $this->course_gateway = new CourseGW($db);
    }

    protected function getALl()
    {
        $result = $this->participant_gateway->getAll();
        return $this->setupSuccessResponse($result);
//        $response['status_code_header'] = 'HTTP/1.1 200 OK';
//        $response['body'] = json_encode($result);
//        return $response;
    }

    protected function getOneById($id)
    {
        $result = $this->participant_gateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        return $this->setupSuccessResponse($result);
    }

    protected function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateParticipant($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->participant_gateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    protected function update($id)
    {
        $result = $this->participant_gateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        //php://input is a read-only stream that allows you to read raw data from the request body.
        // php://input is not available with enctype="multipart/form-data".
        if (!$this->validateParticipant($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->participant_gateway->update($id, $input);
        return $this->setupSuccessResponse(null);
    }

    protected function delete($id)
    {
        $result = $this->participant_gateway->delete($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->participant_gateway->delete($id);
        return $this->setupSuccessResponse(null);
    }



    private function validateParticipant($data){
        /*
            PAR_FNAME
            PAR_LNAME
            PAR_EMAIL
         */

        
		if(!isset($data['PAR_FNAME']) || !isset($data['PAR_LNAME'])){
			return false;
		}
		if (strlen($data['PAR_FNAME'])<=0 || strlen($data['PAR_LNAME'])<=0 ) {
            return false;
        }
        return true;
    }

    protected function getAllByParticipant($id)
    {
        return $this->notFoundResponse();
    }

    protected function getAllByCourse($id)
    {
        $result = $this->course_gateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        $result = $this->participant_gateway->getParticipantsByCourseID($id);
        return $this->setupSuccessResponse($result);
    }

    protected function getAllByMeet($id)
    {
        $result = $this->meet_gateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        $result = $this->participant_gateway->getParticipantsByMeetID($id);
        return $this->setupSuccessResponse($result);
    }
}