<?php
    $category='Посуда';
    $category=$category!=""?" and (c.name=".$category.") ":"";

    $price='200-1000';
    $price=$price!=""?" and (c.price > ".explode("-", $price)[0]."and c.price < ".explode("-", $price)[1].") ":"";

    $query="SELECT
    c.name as category_name, p.id, p.name,  p.description,  p.price,  p.category_id,  p.created 
    FROM  p 
        LEFT JOIN 
        categories c 
        ON p.category_id=c.id 
    WHERE (p.name LIKE ? or c.name LIKE ? or p.description LIKE ?) ".
    $category.$price."
    ORDER BY 
    p.created DESC";
    echo $query;
?>
