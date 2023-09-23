<?php

add_action("ast_tool_content_strong-password-generator", "ast_render_sp_generator_tool_content", 10, 2);
function ast_render_sp_generator_tool_content($tool, $report){
    require_once TOOLS_PATH . "strong-password-generator/template.php";
}

add_action("ast_front_footer", "include_ast_sp_generator_footer_script", 100);
function include_ast_sp_generator_footer_script(){
    $version = filemtime( TOOLS_PATH . "strong-password-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/strong-password-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}