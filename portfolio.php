<?php
include("config/Database.php");

header("Content-Type: application/json;");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");


// För att kunna använda PUT, POST, GET, DELETE
$method = $_SERVER["REQUEST_METHOD"];
//Instans av klassen
$portfolio = new Portfolio();

if (isset($_GET['id'])) {
    $index = $_GET['id'];
}

switch ($method) {
    case "GET":
        // Hämtar datan från en om id angavs
        if (isset($index)) {
            $response = $portfolio->getOnePortfolio($index);
        } else {
            // Hämtar all data om inget id angavs
            $response = $portfolio->getPortfolio();
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
            $portfolio->title = strip_tags($data->title);
            $portfolio->url = strip_tags($data->url);
            $portfolio->desc = strip_tags($data->description);
            $portfolio->image = strip_tags($data->image);
         

        if ($portfolio->addPortfolio()) {
            http_response_code(201);
            $response = array("message" => "Portfolio created"); 
           
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
  
        break;
    case "PUT":
            // Datan som begärs eller skickas 
$data = json_decode(file_get_contents('php://input'));
        // Tar de givna värdena och lägger in i sql-queryn i klass
        $portfolio->title = strip_tags($data->title);
        $portfolio->url = strip_tags($data->url);
        $portfolio->desc = strip_tags($data->description);
        $portfolio->image = strip_tags($data->image);
      

        if ($portfolio->updatePortfolio($index)) {
            http_response_code(200);
            $response = array("message" => "Portfolio updated");
        } else {
            http_response_code(500);
            $response = array("message" => "nope");
        }
        break;
    case "DELETE":
        // Raderar portfolio (rad) i db beroende av givet id
        if(!isset($index)){
            http_response_code(501);
          $response = array("message" => "No id found :/");
      } else{
          // Om id finns
        if ($portfolio->removePortfolio($index)) {
            http_response_code(200);
            $response = array("message" => "Portfolio deleted");
        } else {
            http_response_code(500);
            $response = array("message" => "Deletion incompletion");
        }}
        break;
}
// Skriver ut meddelande/felmeddelande
echo json_encode($response);

