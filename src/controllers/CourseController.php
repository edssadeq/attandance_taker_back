<?php


namespace src\controllers;
use src\db_gateways\CourseGW;
use src\db_gateways\ParticipantGW;


class CourseController extends ControllerAbstract
{

    private $courseGateway;
    private $participantGateway;


    public function __construct($db, $requestMethod, $id)
    {
        parent::__construct($db, $requestMethod, $id);
        $this->courseGateway = new CourseGW($db);
        $this->participantGateway = new ParticipantGW($db);

    }

    protected function getALl()
    {
        $result = $this->courseGateway->getAll();
        return $this->setupSuccessResponse($result);
    }

    protected function getOneById($id)
    {
        $result = $this->courseGateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        return $this->setupSuccessResponse($result);
    }

    protected function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateCourse($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->courseGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    protected function update($id)
    {
        $result = $this->courseGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        //php://input is a read-only stream that allows you to read raw data from the request body.
        // php://input is not available with enctype="multipart/form-data".
        if (! $this->validateCourse($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->courseGateway->update($id, $input);
        return $this->setupSuccessResponse(null);
    }

    protected function getAllByParticipant($id)
    {
        $result = $this->participantGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $result = $this->courseGateway->getCoursesByParticipantID($id);
        return $this->setupSuccessResponse($result);
    }

    protected function delete($id)
    {
        $result = $this->courseGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->courseGateway->delete($id);
        return $this->setupSuccessResponse(null);
    }

    private function validateCourse($input){
        /*
         * COURSE_NAME
         */
        if(!isset($input['COURSE_NAME'])){
            return false;
        }
        return true;
    }

    protected function getAllByCourse($id)
    {
        // TODO: Implement getAllByCourse() method.
        return $this->notFoundResponse();
    }

    protected function getAllByMeet($id)
    {
        // TODO: Implement getAllByMeet() method.
        return $this->notFoundResponse();
    }
}