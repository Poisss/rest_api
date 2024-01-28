<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/post.php";

$database=new Database();
$db=$database->getConnection();
$post=new Post($db);

$post->id=isset($_GET['id'])? $_GET['id']: die();

$stmt=$post->readOne();

if($post->title != null){
    $post_arr=array(
        "id" => $post->id,
        "title" => $post->title,
        "text" => $post->text,
        "topic_id" => $post->topic_id,
        "topic_name" => $post->topic_name,
       "user_id" => $post->user_id,
       "user_firstname" => $post->user_firstname,
       "user_lastname" => $post->user_lastname,
    );
    http_response_code(200);
    echo json_encode($post_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Пост не найден"),JSON_UNESCAPED_UNICODE);
}
?>