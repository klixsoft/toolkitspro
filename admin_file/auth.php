<?php

if( ! defined("ASTROOTPATH") ){
    echo "Not Allowed to access this page.";
    die();
}

global $router;
$active = $router->get_active();

if( ! empty( $active ) ){
    $requirepath = $router->get_active_path();

    if( 
        is_user_loggin()
        && (
            $active['link'] == 'auth/login/' 
            || $active['link'] == 'auth/register/' 
            || $active['link'] == 'auth/forget-password/' 
        )
    ){
        include get_admin_path() . "auth/already.php";
    }else{
        if( file_exists( $requirepath ) ){
            include $requirepath;
        }else{
            include get_admin_path() . "404.php";
        }
    }
}else{
    include get_admin_path() . "404.php";
}
?>