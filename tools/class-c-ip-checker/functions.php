<?php

add_action("ast_tool_content_class-c-ip-checker", "ast_render_class_c_ip_checker_tool_content", 10, 2);
function ast_render_class_c_ip_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Class C IP Address",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Class C IP Address . . ."
    ));
}

add_action("add_scripts", "include_texttohtml_ratio");
function include_texttohtml_ratio(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking Class C IP Address . . .",
        "errormessage" => "Unable to check Class C IP Address. Please try again!!!"
    ))));
}

add_action("ajax/req/process_class-c-ip-checker_checker", "ast_process_class_c_ip_checker_checker");
add_action("ajax/req/nologin/process_class-c-ip-checker_checker", "ast_process_class_c_ip_checker_checker");
function ast_process_class_c_ip_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check Class C IP Address. Please try again!!!"
    );

    if( 
        isset( $_POST['link'] )
        && filter_var( $_POST['link'], FILTER_VALIDATE_URL )
    ){
        $domain = extractHostname(trim($_POST['link']), true);
        $ipApi = new \AST\Helper\IpApi();
        $info = $ipApi->parse($domain);
        if( $info ){
            $ipAddress = $info['content']['ip'];
            $ipParts = explode(".", $ipAddress);
            array_pop($ipParts);
            $classCIP = implode(".", $ipParts);

            ob_start();
            include TOOLS_PATH . "class-c-ip-checker/result.php";

            $output = array(
                "success" => true,
                "message" => ob_get_clean()
            );
        }else{
            $output = array(
                "success" => false,
                "message" => "Unable to check your domain's IP!!!"
            );
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Please enter valid URL!!!"
        );
    }

    ast_send_json($output);
}