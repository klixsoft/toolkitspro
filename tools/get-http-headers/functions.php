<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_get-http-headers", function($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Website Link", array(
        "btnlabel" => "Check HTTP Headers",
        "resultlabel" => "Result",
        "loadingmodal" => "Getting HTTP Headers . . ."
    ));
}, 10, 2);

add_action("add_scripts", "include_http_header_scripts");
function include_http_header_scripts(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js?v=1.2");
    add_code_before_script("toolscript", 'const toolOptions={errormessage : "Unable to check HTTP Headers. Please check link and try again!!!", loadingtext : "Getting HTTP Headers . . ."};');
}

/** HANDLE AJAX REQUEST: GET HTTP HEADERS */
add_action("ajax/req/process_get-http-headers_checker", "ajax_process_get_http_headers_checker");
add_action("ajax/req/nologin/process_get-http-headers_checker", "ajax_process_get_http_headers_checker");
function ajax_process_get_http_headers_checker(){
    if( isset( $_POST['link'] ) && filter_var($_POST['link'], FILTER_VALIDATE_URL) ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $result = get_headers($_POST['link'], false);
            if( !empty( $result ) ){
                ob_start();
                include TOOLS_PATH . "get-http-headers/result.php";
                ast_send_json(array(
                    "success" => true,
                    "message" => ob_get_clean()
                ));
            }

            ast_send_json(array(
                "success" => false,
                "message" => "Unable to check HTTP Headers"
            ));
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Please provide valid URL"
        ));
    }
}

add_action("tkp/api/get-http-headers", "include_get_http_headers_api");
function include_get_http_headers_api(){
    if( isset($_REQUEST['url']) && filter_var($_REQUEST['url'], FILTER_VALIDATE_URL) ){
        $url = trim($_REQUEST['url']);

        $result = get_headers($url, false);
        if( !empty($result) ){
            $output = array();
            foreach($result as $k => $v){
                if( $k == 0 ){
                    list($protocol, $statusCode, $statusMessage) = explode(' ', $v, 3);
                    $output['http'] = array(
                        "protocol" => $protocol,
                        "status" => $statusCode,
                        "message" => $statusMessage
                    );
                }else{
                    $rPart = explode(":", $v);
                    if( isset($rPart[1]) ){
                        $output[trim($rPart[0])] = trim($rPart[1]);
                    }
                }   
            }

            ast_send_json(array(
                "success" => true,
                "headers" => $output
            ));
        }

        ast_send_json(array(
            "success" => false,
            "message" => "Unable to check HTTP Headers"
        ));
    }

    ast_send_json(array(
        "success" => false,
        "message" => "Please provide valid URL"
    ));
}