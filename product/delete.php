<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once "../config/database.php";
include_once "../objects/product.php";

$database=new Database();
$db=$database->getConnection();
$product=new Product($db);

$product->id=isset($_GET['id'])? $_GET['id']: die();

if($product->destroy()){
    http_response_code(201);
    echo json_encode(array("message"=>"Продукт удален"),JSON_UNESCAPED_UNICODE);
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Продукт не получилось удалить"),JSON_UNESCAPED_UNICODE);
}
?>