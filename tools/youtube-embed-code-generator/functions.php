<?php

add_action("ast_tool_content_youtube-embed-code-generator", "ast_render_yt_embed_gen_tool_content", 10, 2);
function ast_render_yt_embed_gen_tool_content($tool, $report){
    require_once TOOLS_PATH . "youtube-embed-code-generator/template.php";
}

add_action("ast_front_footer", "include_ast_yt_embed_gen_footer_script", 100);
function include_ast_yt_embed_gen_footer_script(){
    $version = filemtime( TOOLS_PATH . "youtube-embed-code-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/youtube-embed-code-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}