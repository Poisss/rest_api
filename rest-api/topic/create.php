<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../objects/topic.php";

$database=new Database();
$db=$database->getConnection();

$topic=new Topic($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->name) && !empty($data->description)){
    $topic->name=$data->name;
    $topic->description=$data->description;
    $topic->created=date('Y-m-d H:i:s');
    
    if($topic->store()){
        http_response_code(201);
        echo json_encode(array("message"=>"Тема создана"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Тему не получилось создать"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно создать тему данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>