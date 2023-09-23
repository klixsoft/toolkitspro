<?php

/** INCLUDE TOOL TEMPLATE */
add_action("ast_tool_content_image-to-base64", "ast_render_html_formatter_tool_content", 10, 2);
function ast_render_html_formatter_tool_content($tool, $report){
    require_once TOOLS_PATH . "image-to-base64/template.php";
}


/** INCLUDE FOOTER SCRIPTS */
add_action("ast_front_footer", "include_ast_html_formatter_footer_script", 100);
function include_ast_html_formatter_footer_script(){
    $version = filemtime( TOOLS_PATH . "image-to-base64/main.js" );
    $scripturl = get_site_url() . sprintf("tools/image-to-base64/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}