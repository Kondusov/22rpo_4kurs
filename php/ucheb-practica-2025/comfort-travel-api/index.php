<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch(true) {
    case preg_match('/\/api\/countries(\/\d+)?$/', $request):
        include_once 'api/countries.php';
        break;
    case preg_match('/\/api\/clients(\/\d+)?$/', $request):
        include_once 'api/clients.php';
        break;
    case preg_match('/\/api\/tours(\/\d+)?$/', $request):
        include_once 'api/tours.php';
        break;
    case preg_match('/\/api\/bookings(\/\d+)?$/', $request):
        include_once 'api/bookings.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Маршрут не найден"));
        break;
}
?>