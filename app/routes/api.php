<?php

use AST\View;
use Phroute\Phroute\RouteCollector;

function errorCodes( $key ){
    $errors = array(
        "ERR01" => "Invalid API Key!!!",
        "ERR02" => "No Response!!!",
        "ERR03" => "Route doesn't Exists!!!",
        "ERR04" => "API Limit Exceed!!!",
        "ERR14" => "Invalid Params"
    );

    if( isset( $errors[$key] ) ) return $errors[$key];
    if( empty( $key ) ) return $errors;
    return false;
}

$router->filter('checkapiauth', function(){
    $authToken = getBearerToken();
    define("IS_API", $authToken);
    set_from_apidata();
    
    if( empty( $authToken ) ){
        ast_send_json(array(
            "success" => false,
            "code" => "ERR01",
            "message" => errorCodes("ERR01")
        ), 500);
    }
    
    $currentUser = ast_get_current_user();
    if( empty($currentUser) ){
        ast_send_json(array(
            "success" => false,
            "code" => "ERR01",
            "message" => errorCodes("ERR01")
        ), 500);
    }

    $plan = get_active_user_plan();
    if( empty($plan) || empty( @$plan->apidata ) ){
        ast_send_json(array(
            "success" => false,
            "code" => "ERR01",
            "message" => errorCodes("ERR01")
        ), 500);
    }

    if( empty($plan->apidata->remaining_request) || intval($plan->apidata->remaining_request) <= 0 ){
        ast_send_json(array(
            "success" => false,
            "code" => "ERR04",
            "message" => errorCodes("ERR04")
        ), 500);
    }
});

$router->group(["prefix" => "api/v1"], function(RouteCollector $router){

    $router->get("/", function(){
        ast_send_json(array(
            "success" => true,
            "message" => "Welcome!!!"
        ), 200);
    });

    $router->get("tool/{toolslug:[a-zA-Z0-9_\-]+}/", function( $toolslug ){  
        $tooldata = get_post_by("extra", $toolslug);
        if( empty( $tooldata ) ){
            ast_send_json(array(
                "success" => false,
                "code" => "ERR03",
                "message" => errorCodes("ERR03")
            ), 500);
        }

        $tooldata = (array) $tooldata;
        unset($tooldata['author']);
        unset($tooldata['status']);
        unset($tooldata['type']);

        ast_send_json(array(
            "success" => true,
            "data" => $tooldata
        ), 200);
    });

    $router->group(['before' => 'checkapiauth'], function( RouteCollector $router ){
        $router->get("plugins/", function( ){  
            if( ! headers_sent() )
                header("Access-Control-Allow-Origin: *");

            $plugins = apply_filters("ast/api/plugins", array());
            
            ast_send_json(array(
                "success" => true,
                "data" => $plugins
            ), 200);
        });
        
        $router->post("tool/{toolslug:[a-zA-Z0-9_\-]+}/", function( $toolslug ){
            $tooldata = get_post_by("extra", $toolslug);
            if( empty( $tooldata ) ){
                ast_send_json(array(
                    "success" => false,
                    "code" => "ERR03",
                    "message" => errorCodes("ERR03")
                ), 200);
            }
            
            View::include_tool_functions($tooldata->slug);
            
            if( has_action("tkp/api/$toolslug") ){
                do_action("tkp/api/$toolslug");
            }else{
                ast_send_json(array(
                    "success" => false,
                    "code" => "ERR03",
                    "message" => errorCodes("ERR03")
                ), 500);
            }
    
            ast_send_json(array(
                "success" => false,
                "code" => "ERR02",
                "message" => errorCodes("ERR02")
            ), 500);
        });
    });

});