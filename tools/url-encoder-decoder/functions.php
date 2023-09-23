<?php

add_action("ast_tool_content_url-encoder-decoder", "ast_render_url_encode_decode_tool_content", 10, 2);
function ast_render_url_encode_decode_tool_content($tool, $report){
    require_once TOOLS_PATH . "url-encoder-decoder/template.php";
}

add_action("ast_front_footer", "include_ast_url_encode_decode_footer_script", 100);
function include_ast_url_encode_decode_footer_script(){
    $version = filemtime( TOOLS_PATH . "url-encoder-decoder/main.js" );
    $scripturl = get_site_url() . sprintf("tools/url-encoder-decoder/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}