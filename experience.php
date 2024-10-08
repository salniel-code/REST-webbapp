<?php
include("config/Database.php");

header("Content-Type: application/json; charset=UTF-8;");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

// För att kunna använda PUT, POST, GET, DELETE
$method = $_SERVER["REQUEST_METHOD"];
//Instans av klassen
$experience = new Experience();

// om id finns
if (isset($_GET['id'])) {
    $index = $_GET['id'];
}

switch ($method) {
    case "GET":
        // Hämtar datan från en om id angavs
        if (isset($index)) {
            $response = $experience->getOneExperience($index);
        } else {
            // Hämtar all data om inget id angavs
            $response = $experience->getExperience();
        }
        // Kollar om resultatet (datan) är mer än 0/tom
        if (sizeof($response) > 0) {
            http_response_code(200);
        } else {
            http_response_code(404);
            $response = array("message" => "No data was found");
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'));
        // Tar givna värden till klassens sql-query för att lägga till kolumn
        $experience->workplace = strip_tags($data->workplace);
        $experience->title = strip_tags($data->title);
        $experience->years = strip_tags($data->years);

        if ($experience->addExp()) {
            http_response_code(201);
            $response = array("message" => "experience created");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'));
        // Tar de givna värdena och lägger in i sql-queryn i klass
        $experience->workplace = strip_tags($data->workplace);
        $experience->title = strip_tags($data->title);
        $experience->years = strip_tags($data->years);

        if ($experience->updateExp($index)) {
            http_response_code(200);
            $response = array("message" => "experience updated");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "DELETE":
        // Raderar experience (rad) i db beroende av givet id
        if (!isset($index)) {
            http_response_code(501);
            $response = array("message" => "No id found :/");
        } else {
            // Om id finns
            if ($experience->removeExperience($index)) {
                http_response_code(200);
                $response = array("message" => "experience deleted");
            } else {
                http_response_code(500);
                $response = array("message" => "Deletion incompletion");
            }
        }
        break;
}
// Skriver ut meddelande/felmeddelande
echo json_encode($response);

