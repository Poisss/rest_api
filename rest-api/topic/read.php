<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/topic.php";

$database=new Database();
$db=$database->getConnection();

$topic=new Topic($db);

$stmt=$topic->read();
$num=$stmt->rowCount();

if($num>0){
    $topic_arr=array();
    $topic_arr["records"]=array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $topic_item=array(
            "id" => $id,
            "name" => $name,
            "description" => $description
        );

        array_push($topic_arr["records"],$topic_item);
    }
    http_response_code(200);
    echo json_encode($topic_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Тема не найдены"),JSON_UNESCAPED_UNICODE);
}
?>