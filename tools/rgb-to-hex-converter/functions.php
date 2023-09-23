<?php

add_action("ast_tool_content_rgb-to-hex-converter", "ast_render_rgb_to_hex_tool_content", 10, 2);
function ast_render_rgb_to_hex_tool_content($tool, $report){
    require_once TOOLS_PATH . "rgb-to-hex-converter/template.php";
}

add_action("ast_front_footer", "include_ast_rgb_to_hex_footer_script", 100);
function include_ast_rgb_to_hex_footer_script(){
    $version = filemtime( TOOLS_PATH . "rgb-to-hex-converter/main.js" );
    $scripturl = get_site_url() . sprintf("tools/rgb-to-hex-converter/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}