<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=utf-8");

include_once "../config/core.php";
include_once "../libs/php-jwt-main/src/BeforeValidException.php";
include_once "../libs/php-jwt-main/src/ExpiredException.php";
include_once "../libs/php-jwt-main/src/JWT.php";
include_once "../libs/php-jwt-main/src/SignatureInvalidException.php";
include_once "../libs/php-jwt-main/src/Key.php";

include_once "../config/database.php";
include_once "../objects/user.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$jwt = isset($data->jwt) ? $data->jwt : "";

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key($key, "HS256"));
        $user->id = $data->id;
        $user->firstname  = $data->firstname;
        $user->lastname = $data->lastname;
        $user->patronymic = $data->patronymic;
        $user->email = $data->email;
        $user->password = $data->password;

        if ($user->update()) {
            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "id" => $user->id,
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "patronymic" => $user->patronymic,
                    "email" => $user->email
                )
            );

            http_response_code(200);
            $jwt = JWT::encode($token, $key, "HS256");
            echo json_encode(
                array(
                    "message" => "Пользователь обновлен",
                    "jwt" => $jwt
                )
                );
        }else{
            http_response_code(401);
            echo json_encode(
                array(
                    "message" => "Невозможно обновить ползователя",
                    "jwt" => $jwt
                )
                );
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(
            array(
                "message" => "Вам доступ закрыт",
                "data" => $e->getMessage()
            )
            );
    }
}else{
    http_response_code(401);
    echo json_encode(
        array(
            "message" => "доступ запрещен"
        )
        );
}