<?php

add_action("ast_tool_content_meta-tag-generator", "ast_render_meta_tag_gen_tool_content", 10, 2);
function ast_render_meta_tag_gen_tool_content($tool, $report){
    require_once TOOLS_PATH . "meta-tag-generator/template.php";
}

add_action("ast_front_footer", "include_ast_meta_tag_gen_footer_script", 100);
function include_ast_meta_tag_gen_footer_script(){
    $version = filemtime( TOOLS_PATH . "meta-tag-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/meta-tag-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}