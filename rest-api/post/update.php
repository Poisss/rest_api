<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once "../config/database.php";
include_once "../objects/post.php";

$database=new Database();
$db=$database->getConnection();

$post=new Post($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->id) && !empty($data->title) && !empty($data->text) && !empty($data->topic_id) && !empty($data->user_id)){
    
    $post->id=$data->id;
    $post->title=$data->title;
    $post->text=$data->text;
    $post->topic_id=$data->topic_id;
    $post->user_id=$data->user_id;
    
    if($post->update()){
        http_response_code(201);
        echo json_encode(array("message"=>"Пост обновлен"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Пост не получилось обновить"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно обновить пост данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>