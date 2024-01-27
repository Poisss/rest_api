<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/topic.php";

$database=new Database();
$db=$database->getConnection();
$topic=new Topic($db);

$topic->id=isset($_GET['id'])? $_GET['id']: die();

$stmt=$topic->readOne();

if($topic->name != null){
    $topic_arr=array(
        "id" => $topic->id,
        "name" => $topic->name,
        "description" => $topic->description,
    );
    http_response_code(200);
    echo json_encode($topic_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Тема не найдена"),JSON_UNESCAPED_UNICODE);
}
?>