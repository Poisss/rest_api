<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/product.php";

$database=new Database();
$db=$database->getConnection();

$product=new Product($db);

$json=file_get_contents('php://input');
$data=json_decode($json);

$products->id=!empty($data->id)? $data->id: die();

$stmt=$product->readOne();

if($product->name != null){
    $product_arr=array(
        "id" => $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category_id" => $product->category_id,
       "category_name" => $product->category_name,
    );
    http_response_code(200);
    echo json_encode($product_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message"=>"Товар не найден"),JSON_UNESCAPED_UNICODE);
}
?>