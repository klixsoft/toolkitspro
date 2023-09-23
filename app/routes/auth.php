<?php

use AST\View;
use Phroute\Phroute\RouteCollector;

$router->group(["prefix" => "auth", "before" => "alreadylogin"], function(RouteCollector $router){

    $router->get("login/", function(){
        return View::render("login");
    });

    $router->get("forget-password/", function(){
        return View::render("forget-password");
    });

    $router->get("register/", function(){
        return View::render("register");
    });

});