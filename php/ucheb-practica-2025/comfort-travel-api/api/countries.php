<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Country.php';


$database = new Database();
$db = $database->getConnection();
$country = new Country($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $country->read();
        $num = $stmt->rowCount();
        
        if($num > 0) {
            $countries_arr = array();
            $countries_arr["data"] = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $country_item = array(
                    "id" => $id,
                    "name" => $name,
                    "code" => $code,
                    "visa_required" => (bool)$visa_required,
                    "created_at" => $created_at
                );
                array_push($countries_arr["data"], $country_item);
            }
            
            http_response_code(200);
            echo json_encode($countries_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Страны не найдены."));
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->name) && !empty($data->code)) {
            $country->name = $data->name;
            $country->code = $data->code;
            $country->visa_required = isset($data->visa_required) ? $data->visa_required : false;
            
            if($country->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Страна создана."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Невозможно создать страну."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Невозможно создать страну. Данные неполные."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->id) && !empty($data->name) && !empty($data->code)) {
            $country->id = $data->id;
            $country->name = $data->name;
            $country->code = $data->code;
            $country->visa_required = isset($data->visa_required) ? $data->visa_required : false;
            
            if($country->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Страна обновлена."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Невозможно обновить страну."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Невозможно обновить страну. Данные неполные."));
        }
        break;
        
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->id)) {
            $country->id = $data->id;
            
            if($country->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Страна удалена."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Невозможно удалить страну."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Укажите ID страны для удаления."));
        }
        break;
}
?>