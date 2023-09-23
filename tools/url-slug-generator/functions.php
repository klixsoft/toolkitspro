<?php

add_action("ast_tool_content_url-slug-generator", "ast_render_url_slug_gen_tool_content", 10, 2);
function ast_render_url_slug_gen_tool_content($tool, $report){
    require_once TOOLS_PATH . "url-slug-generator/template.php";
}

add_action("ast_front_footer", "include_domain_url_slug_gen_footer_script", 100);
function include_domain_url_slug_gen_footer_script(){
    $version = filemtime( TOOLS_PATH . "url-slug-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/url-slug-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}