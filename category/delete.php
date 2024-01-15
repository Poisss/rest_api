<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/category.php";

$database=new Database();
$db=$database->getConnection();
$category=new Category($db);

$category->id=isset($_GET['id'])? $_GET['id']: die();

if($category->delete()){
    http_response_code(201);
    echo json_encode(array("message"=>"Категория удалена"),JSON_UNESCAPED_UNICODE);
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Категорию не получилось удалить"),JSON_UNESCAPED_UNICODE);
}
?>