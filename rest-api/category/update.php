<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

include_once "../config/database.php";
include_once "../objects/category.php";

$database=new Database();
$db=$database->getConnection();

$product=new Category($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->id) && !empty($data->name) && !empty($data->description)){
    
    $product->id=$data->id;
    $product->name=$data->name;
    $product->description=$data->description;
    
    if($product->update()){
        http_response_code(201);
        echo json_encode(array("message"=>"Продукт обновлен"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Продукт не получилось обновить"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно обновить товар данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>