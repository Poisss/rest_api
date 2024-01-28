<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

include_once "../config/database.php";
include_once "../config/core.php";
include_once "../objects/post.php";
include_once "../shared/utilities.php";

$utilities = new Utilities();

$database = new Database();
$db =$database->getConnection();
$post = new Post($db);

$keywords1=isset($_GET['keywords'])? $_GET['keywords']: "";
$topic1=isset($_GET['topic'])? $_GET['topic']: "";
$user_id1=isset($_GET['user_id'])? $_GET['user_id']: "";
$attr_arr=array(
        "keywords"=>$keywords1,
        "topic"=>$topic1,
        "user_id"=>$user_id1,
    );
$stmt = $post->searchPaging($attr_arr,$from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num > 0) {
    $post_arr = array();
    $post_arr["records"] = array();
    $post_arr["paging"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            "id" => $id,
            "title" => $title,
            "text" => $text,
            "topic_id" => $topic_id,
            "topic_name" => $topic_name,
            "user_id" => $user_id,
            "user_firstname" => $user_firstname,
            "user_lastname" => $user_lastname,
        );
       array_push($post_arr["records"], $post_item);
    }

    $total_rows=$post->count($attr_arr);
    $page_url = "{$home_url}post/search_paging.php?";
    $paging = $utilities->getPaging($attr_arr,$page, $total_rows, $records_per_page, $page_url);
    $post_arr["paging"] = $paging;

    echo json_encode($post_arr);
    http_response_code(200);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Посты не найдены"), JSON_UNESCAPED_UNICODE);

}