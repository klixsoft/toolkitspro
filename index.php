<?php

use AST\View;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

/**Require All Setup Files */
require_once realpath(__DIR__) . '/load.php';

/** Redirect if not installed and try to access website */
if( ! has_system_installed() && is_not_install_page() ){
    redirect("install/");
    exit;
}

function handle_404_page( $th ){
    status_header(404);
    if( View::is_admin() || View::is_auth() ){
        get_header_file();
        include ASTROOTPATH . "admin_file/404.php";
        get_footer_file();
    }else if( View::is_front() ){
        do_action("add_scripts");
        $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
            "title" => "404 Page Not Found - %sitename%",
            "description" => "The page you are looking for might have been removed has it's name changed or temporarily unavailable.",
            "link" => get_site_url("contact/")
        ));
        get_header_file(array(
            "metainfo" => $metainfo
        ));
        include get_theme_path() . "404.php";
        get_footer_file();
    }else if( View::is_api() ){
        ast_send_json(array(
            "success" => false,
            "message" => $th->getMessage()
        ), 404);
    }
}

try {
    $dispatcher = new Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo apply_filters( "ast/html", $response );
} catch (HttpRouteNotFoundException $th) {
    handle_404_page( $th );
} catch(HttpMethodNotAllowedException $th){
    handle_404_page( $th );
}