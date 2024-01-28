<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once "../config/database.php";
include_once "../objects/post.php";

$database=new Database();
$db=$database->getConnection();
$post=new Post($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->id)){
    $post->id=$data->id;

    if($post->destroy()){
        http_response_code(201);
        echo json_encode(array("message"=>"Пост удален"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Пост не получилось удалить"),JSON_UNESCAPED_UNICODE);
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно удалить пост данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>