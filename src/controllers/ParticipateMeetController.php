<?php


namespace src\controllers;
use src\db_gateways\MeetGW;
use src\db_gateways\ParticipantGW;
use src\db_gateways\ParticipateMeetGW;

class ParticipateMeetController extends ControllerAbstract
{
    private $meetGateway;
    private $participantGateway;
    private $participateMeetGateway;


    public function __construct($db, $requestMethod, $id)
    {
        parent::__construct($db, $requestMethod, $id);
        $this->meetGateway = new MeetGW($db);
        $this->participantGateway = new ParticipantGW($db);
        $this->participateMeetGateway = new ParticipateMeetGW($db);

    }


    protected function getALl()
    {
        $result = $this->participateMeetGateway->getAll();
        return $this->setupSuccessResponse($result);
    }

    protected function getOneById($id)
    {
        $result = $this->participateMeetGateway->getOne($id);
        if(!$result){
            return $this->notFoundResponse();
        }
        return $this->setupSuccessResponse($result);
    }

    protected function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateData($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->participateMeetGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    protected function update($id)
    {
        // TODO: Implement update() method.
    }

    protected function delete($id)
    {
        $result = $this->participateMeetGateway->getOne($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->participateMeetGateway->delete($id);
        return $this->setupSuccessResponse(null);
    }

    protected function getAllByParticipant($id)
    {
        // TODO: Implement getAllByParticipant() method.
    }

    protected function getAllByCourse($id)
    {
        // TODO: Implement getAllByCourse() method.
    }

    protected function getAllByMeet($id)
    {
        // TODO: Implement getAllByMeet() method.
    }

    private function validateData($data): bool{
        if(!isset($data['PAR_ID']) || !isset($data['MEET_ID'])){
            return false;
        }
        return true;
    }
}