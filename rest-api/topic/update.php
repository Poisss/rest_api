<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once "../config/database.php";
include_once "../objects/topic.php";

$database=new Database();
$db=$database->getConnection();

$topic=new Topic($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->id) && !empty($data->name) && !empty($data->description)){
    
    $topic->id=$data->id;
    $topic->name=$data->name;
    $topic->description=$data->description;
    
    if($topic->update()){
        http_response_code(201);
        echo json_encode(array("message"=>"Тема обновлена"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Тему не получилось обновить"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно обновить тему данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>