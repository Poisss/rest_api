<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once "../config/database.php";
include_once "../objects/user.php";

$database=new Database();
$db=$database->getConnection();
$user=new User($db);

$user->id=isset($_GET['id'])? $_GET['id']: die();

if($user->destroy()){
    http_response_code(201);
    echo json_encode(array("message"=>"Категория удалена"),JSON_UNESCAPED_UNICODE);
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Категорию не получилось удалить"),JSON_UNESCAPED_UNICODE);
}
?>