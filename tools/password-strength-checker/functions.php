<?php

use AllSmartTools\Helper\Cache;

add_action("ast_tool_content_password-strength-checker", "ast_render_ps_checker_tool_content", 10, 2);
function ast_render_ps_checker_tool_content($tool, $report){
    require_once TOOLS_PATH . "password-strength-checker/template.php";
}

add_action("ast_front_footer", "include_ast_ps_checker_footer_script", 100);
function include_ast_ps_checker_footer_script(){
    $version = filemtime( TOOLS_PATH . "password-strength-checker/main.js" );
    $scripturl = get_site_url() . sprintf("tools/password-strength-checker/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}