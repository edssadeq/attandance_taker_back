<?php
require_once __DIR__."/../bootstrap.php";
use src\controllers\ParticipantController;
use src\controllers\MeetController;
use src\controllers\CourseController;
use src\controllers\FollowCourseController;
use src\controllers\ParticipateMeetController;

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Access-Control-Allow-Headers, Authorization");
//fixing (CORS) problem
header("Access-Control-Allow-Headers: *");


/*
 * URLS : /participant
 *        /participant/{id}
 *        /participant/meet={id}
 *        /participant/course={id}
 *
 *        /meet
 *        /meet/{id}
 *        /meet/par={id}
 *        /meet/course={id}
 *
 *        /course
 *        /course/{id}
 *        /course/par={id}
 *
 *        /participate_meet
 *        /participate_meet/par={id}/meet={id} POST
 *
 *        /follow_course
 *        /follow_course/par={id}/coures={id} POST
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

//var_dump($uri);

switch ($uri[1]){
    case "participants":
        $id = isset($uri[2]) ? $uri[2] :  null;
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new ParticipantController($dbconnction, $requestMethod, $id);
        $controller->processRequest();

        break;
    case "meets":

        $id = isset($uri[2]) ? $uri[2] :  null;
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new MeetController($dbconnction, $requestMethod, $id);
        $controller->processRequest();

        break;
    case "courses":
        $id = isset($uri[2]) ? $uri[2] :  null;
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new CourseController($dbconnction, $requestMethod, $id);
        $controller->processRequest();

        break;
    case "participate_meet":
        $par_id = isset($uri[2]) ? $uri[2] :  null;
        $meet_id = isset($uri[3]) ? $uri[3] :  null;
        $id = null;
        if($par_id && $meet_id){
            $id = array('PAR_ID'=>$par_id, 'MEET_ID'=>$meet_id);
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new ParticipateMeetController($dbconnction, $requestMethod, $id);
        $controller->processRequest();
        break;

    case "follow_course":

        $par_id = isset($uri[2]) ? $uri[2] :  null;
        $course_id = isset($uri[3]) ? $uri[3] :  null;
        $id = null;
        if($par_id && $course_id){
            $id = array('PAR_ID'=>$par_id, 'COURSE_ID'=>$course_id);
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $controller = new FollowCourseController($dbconnction, $requestMethod, $id);
        $controller->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["message" => "Request Not Found !"]);
        break;

}

