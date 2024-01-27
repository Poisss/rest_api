<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=utf-8");

include_once "../config/core.php";
include_once "../libs/php-jwt-main/src/BeforeValidException.php";
include_once "../libs/php-jwt-main/src/ExpiredException.php";
include_once "../libs/php-jwt-main/src/SignatureInvalidException.php";
include_once "../libs/php-jwt-main/src/JWT.php";
include_once "../libs/php-jwt-main/src/Key.php";

$data = json_decode(file_get_contents("php://input"));

$jwt  = isset($data->jwt) ? $data->jwt : "";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key($key, "HS256"));
        http_response_code(200);
            echo json_encode(array(
            "message" => "Доступ разрешен",
            "data" => $decoded->data
        ));
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "message" => "Доступ закрыт",
            "data" => $e->getMessage()
        ));

    }
}else{
    http_response_code(401);
    echo json_encode(array(
        "message" => "Доступ запрещен",
        "data" => $e->getMessage()
));
}