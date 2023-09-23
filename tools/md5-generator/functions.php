<?php

use AllSmartTools\Helper\Cache;

if( ! function_exists( "peu_html_render" ) ){
    function peu_html_render($title, $output){
        return sprintf('<div class="row position-relative">
            <div class="col-md-2 col-sm-3 col-4 p-2"><strong>%s</strong></div>
            <div class="col-md-9 col-sm-7 col-8 p-2">
                <div class="passed_value">%s</div>
                <button class="btn btn-outline-primary rounded-circle copy-clipboard" type="button" title="Click to Copy"><i class="las la-copy"></i></button>
            </div>
            <div class="col-md-1 col-sm-2 p-2">
                <button class="btn btn-outline-primary rounded-circle copy-clipboard" type="button" title="Click to Copy"><i class="las la-copy"></i></button>
            </div>
        </div>', $title, $output);
    }
}

add_action("ast_tool_content_md5-generator", "ast_render_md5_generator_tool_content", 10, 2);
function ast_render_md5_generator_tool_content($tool, $report){
    require_once TOOLS_PATH . "md5-generator/template.php";
}

add_action("ast_front_footer", "include_ast_md5_generator_footer_script", 100);
function include_ast_md5_generator_footer_script(){
    $version = filemtime( TOOLS_PATH . "md5-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/md5-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}

add_action("ajax/req/process_md5-generator_checker", "ast_process_md5_generator_ajax");
add_action("ajax/req/nologin/process_md5-generator_checker", "ast_process_md5_generator_ajax");
function ast_process_md5_generator_ajax(){
    if( isset( $_POST['password'] ) && !empty( $_POST['password'] ) ){
        $password = trim($_POST['password']);

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $html = peu_html_render("Original Text", $password);
            $html .= peu_html_render("MD5 Hash", md5($password));

            ast_send_json(array(
                "success" => true,
                "message" => $html
            ));
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Password Text Should not be empty"
        ));
    }
}