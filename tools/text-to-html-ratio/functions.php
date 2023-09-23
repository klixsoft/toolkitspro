<?php

/** INCLUDE TOOL CONTENT */
add_action("ast_tool_content_text-to-html-ratio", "ast_render_text_to_html_ratio_tool_content", 10, 2);
function ast_render_text_to_html_ratio_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Text to HTML Ratio",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Text to HTML Ratio . . ."
    ));
}

/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_texttohtml_ratio");
function include_texttohtml_ratio(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Check Text to HTML Ratio . . .",
        "errormessage" => "Unable to check text to HTML Ratio. Please try again!!!"
    ))));
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_text-to-html-ratio_checker", "ast_process_text_to_html_ratio_checker");
add_action("ajax/req/nologin/process_text-to-html-ratio_checker", "ast_process_text_to_html_ratio_checker");
function ast_process_text_to_html_ratio_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check text to HTML Ratio. Please try again!!!"
    );

    if( 
        isset( $_POST['link'] )
        && filter_var( $_POST['link'], FILTER_VALIDATE_URL )
    ){
        $content = url_get_contents(trim($_POST['link']));
        $orglen = strlen($content);
        $content = preg_replace('/(<script.*?>.*?<\/script>|<style.*?>.*?<\/style>|<.*?>|\r|\n|\t)/ms', '', $content);  
        $content = preg_replace('/ +/ms', ' ', $content);  
        $textlen = strlen($content);
        $codelen = $orglen - $textlen;
        $per = (($textlen * 100) / $orglen);

        ob_start();
        include TOOLS_PATH . "text-to-html-ratio/result.php";

        $output = array(
            "success" => true,
            "message" => ob_get_clean()
        );
    }else{
        $output = array(
            "success" => false,
            "message" => "Please enter valid URL!!!"
        );
    }

    ast_send_json($output);
}