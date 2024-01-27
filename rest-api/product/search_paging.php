<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

include_once "../config/database.php";
include_once "../config/core.php";
include_once "../objects/product.php";
include_once "../shared/utilities.php";

$utilities = new Utilities();

$database = new Database();
$db =$database->getConnection();
$product = new Product($db);

$keywords1=isset($_GET['keywords'])? $_GET['keywords']: "";
$category1=isset($_GET['category'])? $_GET['category']: "";
$price1=isset($_GET['price'])? $_GET['price']: "";

$stmt = $product->searchPaging($keywords1,$category1,$price1,$from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num > 0) {
    $products_arr = array();
    $products_arr["records"] = array();
    $products_arr["paging"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name,
        );
       array_push($products_arr["records"], $product_item);
    }

    $total_rows=$product->count($keywords1,$category1,$price1);
    $page_url = "{$home_url}product/search_paging.php?";
    $paging = $utilities->getPaging($keywords1,$category1,$price1,$page, $total_rows, $records_per_page, $page_url);
    $products_arr["paging"] = $paging;

    echo json_encode($products_arr);
    http_response_code(200);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Товары не найдены"), JSON_UNESCAPED_UNICODE);

}