<?php

add_action("ast_tool_content_hex-to-rgba-converter", "ast_render_hex_to_rgba_tool_content", 10, 2);
function ast_render_hex_to_rgba_tool_content($tool, $report){
    require_once TOOLS_PATH . "hex-to-rgba-converter/template.php";
}

add_action("ast_front_footer", "include_ast_hex_to_rgba_footer_script", 100);
function include_ast_hex_to_rgba_footer_script(){
    $version = filemtime( TOOLS_PATH . "hex-to-rgba-converter/main.js" );
    $scripturl = get_site_url() . sprintf("tools/hex-to-rgba-converter/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}