<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once "../config/database.php";
include_once "../objects/user.php";

$database=new Database();
$db=$database->getConnection();

$user=new User($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->id) && !empty($data->firstname) && !empty($data->lastname) && !empty($data->patronymic) && !empty($data->email) && !empty($data->password)){
    
    $user->id=$data->id;
    $user->firstname=$data->firstname;
    $user->lastname=$data->lastname;
    $user->patronymic=$data->patronymic;
    $user->email=$data->email;
    $user->password=$data->password;
    
    if($user->update()){
        http_response_code(201);
        echo json_encode(array("message"=>"Данные пользователя обновлены"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Данные пользователя не получилось обновить"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно обновить данные пользователя они не полные"),JSON_UNESCAPED_UNICODE);
}
?>