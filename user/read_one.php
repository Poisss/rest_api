<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/user.php";

$database=new Database();
$db=$database->getConnection();
$user=new User($db);

$user->id=isset($_GET['id'])? $_GET['id']: die();

$stmt=$user->readOne();

if($user->firstname != null){
    $user_arr=array(
        "id" => $user->id,
        "firstname" => $user->firstname,
        "lastname" => $user->lastname,
        "patronymic" => $user->patronymic,
        "email" => $user->email
    );
    http_response_code(200);
    echo json_encode($user_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Пользователь не найден"),JSON_UNESCAPED_UNICODE);
}
?>