<?php
include("config/Database.php");

header("Content-Type: application/json;");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");


// För att kunna använda PUT, POST, GET, DELETE
$method = $_SERVER["REQUEST_METHOD"];
//Instans av klassen
$skills = new Skills();

if (isset($_GET['id'])) {
    $index = $_GET['id'];
}

switch ($method) {
    case "GET":
        // Hämtar datan från en om id angavs
        if (isset($index)) {
            $response = $skills->getOneSkill($index);
        } else {
            // Hämtar all data om inget id angavs
            $response = $skills->getskills();
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

        // Datan som begärs eller skickas 
        $data = json_decode(file_get_contents('php://input'));
        // Tar givna värden till klassens sql-query för att lägga till kolumn
        $skills->language = strip_tags($data->lang);
        $skills->description = strip_tags($data->description);

        if ($skills->addSkills()) {
            http_response_code(201);
            $response = array("message" => "skills created");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }

        break;
    case "PUT":
        // Datan som begärs eller skickas 
        $data = json_decode(file_get_contents('php://input'));
        // Tar de givna värdena och lägger in i sql-queryn i klass
        $skills->language = strip_tags($data->lang);
        $skills->description = strip_tags($data->description);

        if ($skills->updateSkills($index)) {
            http_response_code(200);
            $response = array("message" => "skills updated");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "DELETE":
        // Raderar skills (rad) i db beroende av givet id
        if (!isset($index)) {
            http_response_code(501);
            $response = array("message" => "No id found :/");
        } else {
            // Om id finns
            if ($skills->removeSkills($index)) {
                http_response_code(200);
                $response = array("message" => "skills deleted");
            } else {
                http_response_code(500);
                $response = array("message" => "Deletion incompletion");
            }
        }
        break;
}
// Skriver ut meddelande/felmeddelande
echo json_encode($response);
