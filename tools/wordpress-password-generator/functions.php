<?php

use AllSmartTools\Helper\Cache;

if( ! function_exists( "peu_html_render" ) ){
    function peu_html_render($title, $output){
        return sprintf('<div class="row position-relative">
            <div class="col-md-2 col-sm-3 col-4 p-2"><strong>%s</strong></div>
            <div class="col-md-9 col-sm-7 col-8 p-2">
                <div class="passed_value">%s</div>
                <button class="btn btn-outline-primary rounded-circle copy-clipboard" title="Click to Copy" type="button"><i class="las la-copy"></i></button>
            </div>
            <div class="col-md-1 col-sm-2 p-2">
                <button class="btn btn-outline-primary rounded-circle copy-clipboard" title="Click to Copy" type="button"><i class="las la-copy"></i></button>
            </div>
        </div>', $title, $output);
    }
}

add_action("ast_tool_content_wordpress-password-generator", "ast_render_wp_generator_tool_content", 10, 2);
function ast_render_wp_generator_tool_content($tool, $report){
    require_once TOOLS_PATH . "wordpress-password-generator/template.php";
}

add_action("ast_front_footer", "include_ast_wp_generator_footer_script", 100);
function include_ast_wp_generator_footer_script(){
    $version = filemtime( TOOLS_PATH . "wordpress-password-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/wordpress-password-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}


add_action("ajax/req/process_wordpress-password-generator_checker", "ast_process_wp_password_generator_ajax");
add_action("ajax/req/nologin/process_wordpress-password-generator_checker", "ast_process_wp_password_generator_ajax");
function ast_process_wp_password_generator_ajax(){
    if( isset( $_POST['password'] ) && !empty( $_POST['password'] ) ){
        $password = trim($_POST['password']);

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $hash = generate_password($password, strlen($password));

            $html = peu_html_render("Original Text", $password);
            $html .= peu_html_render("Wordpress Hash", $hash);

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