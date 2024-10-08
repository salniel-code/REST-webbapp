<?php
include("config/Database.php");

// För att requests ska fungera, bla cross-origin
header("Content-Type: application/json; charset=UTF-8;");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

// För att kunna använda PUT, POST, GET, DELETE
$method = $_SERVER["REQUEST_METHOD"];
//Instans av klassen
$school = new School();


if (isset($_GET['id'])) {
    $index = $_GET['id'];
}

switch ($method) {
    case "GET":
 if (isset($index)){
     // Hämtar en om id angavs
      $response = $school->getOneSchool($index);
 }else {
      // Hämtar all data
        $response = $school->getSchool();
     
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
        $school->school = strip_tags($data->school);
        $school->name = strip_tags($data->name);
        $school->years = strip_tags($data->years);

        if ($school->addSchool()) {
            http_response_code(201);
            $response = array("message" => "school created");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "PUT":
        // Datan som begärs eller skickas 
$data = json_decode(file_get_contents('php://input'));
        // Tar de givna värdena och lägger in i sql-queryn i klass
        $school->school = strip_tags($data->school);
        $school->name = strip_tags($data->name);
        $school->years = strip_tags($data->years);
       

        if ($school->updateSchool($index)) {
            http_response_code(200);
            $response = array("message" => "school updated");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "DELETE":
        // Raderar school (rad) i db beroende av givet id
       if (!isset($index)) {
            http_response_code(501);
            $response = array("message" => "No id found :/");
        }else {
            
              if ($school->removeSchool($index)) {
            http_response_code(200);
            $response = array("message" => "school deleted");
        } else {
            http_response_code(500);
            $response = array("message" => "Deletion incompletion");
        }
            
        }
        
        
      
        break;
}
// Skriver ut meddelande/felmeddelande
echo json_encode($response);
