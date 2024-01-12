<?php
    $path= $_SERVER['REQUEST_URI'];
    $command=explode('/',$path);
    match ($command[1]) {
        'products'=> products(),
        default => '404',
    };
    function products(){
        echo'prodicts';
    }
?>
