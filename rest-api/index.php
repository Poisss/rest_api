<?php

    $query="SELECT
    c.name as category_name, p.id, p.name,  p.description,  p.price,  p.category_id,  p.created 
    FROM  p 
        LEFT JOIN 
        categories c 
        ON p.category_id=c.id 
    ORDER BY 
    p.created DESC 
    LIMIT ?, ?";
    echo $query;
?>
