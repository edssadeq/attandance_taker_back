<?php


namespace src\controllers;


abstract class ControllerAbstract
{
    private $db;
    private $requestMethod;
    private $id;

    public function __construct($db, $requestMethod, $id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $id;
    }

    abstract protected function  getALl();

    abstract protected function getOneById($id);

    abstract protected function create();

    abstract protected function update($id);

    abstract protected function delete($id);

    abstract protected function getAllByParticipant($id); //get meets by participants, get course by participants
    abstract protected function getAllByCourse($id); //get meets by course, get participantrs by course
    abstract protected function getAllByMeet($id); //get participants by meet

    protected function setupSuccessResponse($data){
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($data);
        return $response;
    }

    protected function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
//        $response['body'] = null;
        $response['body'] = json_encode(["message" => "No data found !"]);

        return $response;
    }

    protected function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }





    public function processRequest()
    {
        $isIDString = gettype($this->id) == 'string';
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id) {
                    if($isIDString && str_starts_with(strval($this->id), "par=")){
                        //get participantId
                        $par = explode("=", $this->id);
                        $par_id = (int)$par[1];
                        $response = $this->getAllByParticipant($par_id);
                    }
                    elseif ($isIDString && str_starts_with(strval($this->id), "course=")){
                        //get courseId
                        $par = explode("=", $this->id);
                        $course_id = (int)$par[1];
                        $response = $this->getAllByCourse($course_id);
                    }
                    elseif ($isIDString && str_starts_with(strval($this->id), "meet=")){
                        //get meetId
                        $par = explode("=", $this->id);
                        $meetid = $par[1];
                        $response = $this->getAllByMeet($meetid);
                    }
                    elseif (isset($this->id['PAR_ID']) && str_starts_with(strval($this->id['PAR_ID']), "par=")){
                        $par_id = explode("=", $this->id['PAR_ID']);

                        if (isset($this->id['MEET_ID']) && str_starts_with(strval($this->id['MEET_ID']), "meet=")){
                            // TODO: implement /participate_meet/par=/meet=
                            $mee_id = explode("=", $this->id['MEET_ID']);
                            $id = ['PAR_ID'=> $par_id[1], 'MEET_ID'=> $mee_id[1]];
                            $response = $this->getOneById($id);
                        }
                        elseif (isset($this->id['COURSE_ID']) && str_starts_with(strval($this->id['COURSE_ID']), "course=")){
                            // TODO: implement /follow_course/par=/course=
                            $course_id = explode("=", $this->id['COURSE_ID']);
                            $id = ['PAR_ID'=> $par_id[1], 'COURSE_ID'=> $course_id[1]];
                            $response = $this->getOneById($id);
                        }
                        else{
                            $response = $this->getALl();
                        }
                    }
                    else{
                        $response = $this->getOneById($this->id);
                    }
                } else {
                    $response = $this->getALl();
                    //$response['status_code_header'] = 'HTTP/1.1 200 OK';
                    //$response['body'] = "Hi there";
                    //echo "getAll()";
                    //var_dump($this->getALl());

                };
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->update($this->id);
                break;
            case 'DELETE':
                if(isset($this->id['PAR_ID']) && str_starts_with(strval($this->id['PAR_ID']), "par=")){
                    $par_id = explode("=", $this->id['PAR_ID']);

                    if (isset($this->id['MEET_ID']) && str_starts_with(strval($this->id['MEET_ID']), "meet=")){
                        // TODO: implement /participate_meet/par=/meet=
                        $mee_id = explode("=", $this->id['MEET_ID']);
                        $id = ['PAR_ID'=> $par_id[1], 'MEET_ID'=> $mee_id[1]];
                        $response = $this->delete($id);
                    }
                    elseif (isset($this->id['COURSE_ID']) && str_starts_with(strval($this->id['COURSE_ID']), "course=")){
                        // TODO: implement /follow_course/par=/course=
                        $course_id = explode("=", $this->id['COURSE_ID']);
                        $id = ['PAR_ID'=> $par_id[1], 'COURSE_ID'=> $course_id[1]];
                        $response = $this->delete($id);
                    }
                    else{
                        $response = $this->notFoundResponse();
                    }
                }
                else{
                    $response = $this->delete($this->id);
                }
                break;
			case 'OPTIONS': //Fixing the Problems with CORS
				$response = $this->setupSuccessResponse(null);
				break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

}