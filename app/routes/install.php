<?php
use AST\View;

$router->get("/install", function(){
    if( defined("DB_NAME") && !str_contains(DB_NAME, "}}") ){
        redirect(get_site_url());
        exit;
    }

    return View::render("index");
});