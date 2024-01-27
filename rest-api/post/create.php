<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../objects/product.php";

$database=new Database();
$db=$database->getConnection();

$product=new Product($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

if(!empty($data->name) && !empty($data->description) && !empty($data->price) && !empty($data->category_id)){
    $product->name=$data->name;
    $product->description=$data->description;
    $product->price=$data->price;
    $product->category_id=$data->category_id;
    $product->created=date('Y-m-d H:i:s');
    
    if($product->store()){
        http_response_code(201);
        echo json_encode(array("message"=>"Продукт создан"),JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
        echo json_encode(array("message"=>"Продукт не получилось создать"),JSON_UNESCAPED_UNICODE);
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message"=>"Неврозможно создать товар данные не полные"),JSON_UNESCAPED_UNICODE);
}
?>