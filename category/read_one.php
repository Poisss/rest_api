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

$stmt=$category->readOne();

if($category->name != null){
    $category_arr=array(
        "id" => $category->id,
        "name" => $category->name,
        "description" => $category->description,
    );
    http_response_code(200);
    echo json_encode($category_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Категория не найдена"),JSON_UNESCAPED_UNICODE);
}
?>