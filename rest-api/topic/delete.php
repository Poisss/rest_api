<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once "../config/database.php";
include_once "../objects/topic.php";

$database=new Database();
$db=$database->getConnection();
$topic=new Topic($db);

$topic->id=isset($_GET['id'])? $_GET['id']: die();

if($topic->destroy()){
    http_response_code(201);
    echo json_encode(array("message"=>"Тема удалена"),JSON_UNESCAPED_UNICODE);
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Тему не получилось удалить"),JSON_UNESCAPED_UNICODE);
}
?>