<?php

if( ! function_exists( "get_aspect_ratios" ) ){
    /**
     * Get aspect ratios
     */
    function get_aspect_ratios(){
        return array(
            array(
                "width" => 30,
                "height" => 30,
                "ratio" => "1:1"
            ),
            array(
                "width" => 40,
                "height" => 26.67,
                "ratio" => "3:2"
            ),
            array(
                "width" => 40,
                "height" => 24,
                "ratio" => "5:3"
            ),
            array(
                "width" => 30,
                "height" => 30,
                "ratio" => "4:3"
            ),
            array(
                "width" => 37.5,
                "height" => 30,
                "ratio" => "5:4"
            ),
            array(
                "width" => 40,
                "height" => 26.67,
                "ratio" => "6:4"
            ),
            array(
                "width" => 40,
                "height" => 28.57,
                "ratio" => "7:5"
            ),
            array(
                "width" => 37.5,
                "height" => 20,
                "ratio" => "10:8"
            ),
            array(
                "width" => 40,
                "height" => 22.5,
                "ratio" => "16:9"
            )
        );
    }
}

/** INCLUDE TOOL TEMPLATE */
add_action("ast_tool_content_image-cropping-tool", "ast_render_html_formatter_tool_content", 10, 2);
function ast_render_html_formatter_tool_content($tool, $report){
    require_once TOOLS_PATH . "image-cropping-tool/template.php";
}


/** INCLUDE FOOTER SCRIPTS */
add_action("ast_front_footer", "include_ast_html_formatter_footer_script", 100);
function include_ast_html_formatter_footer_script(){

    $scripturl = get_site_url() . "tools/image-cropping-tool/cropperjs/dist/cropper.min.css";
    echo sprintf('<link rel="stylesheet" href="%s">', $scripturl);

    $scripturl = get_site_url() . "tools/image-cropping-tool/cropperjs/dist/cropper.min.js";
    echo sprintf('<script src="%s"></script>', $scripturl);

    $version = filemtime( TOOLS_PATH . "image-cropping-tool/main.js" );
    $scripturl = get_site_url() . sprintf("tools/image-cropping-tool/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}


/** FULL WIDTH TEMPLATE */
add_filter( "ast/tool/render/sidebar", function(){
    return false;
});