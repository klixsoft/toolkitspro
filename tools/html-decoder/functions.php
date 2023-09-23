<?php

add_action("ast_tool_content_html-decoder", "ast_render_html_formatter_tool_content", 10, 2);
function ast_render_html_formatter_tool_content($tool, $report){
    require_once TOOLS_PATH . "html-decoder/template.php";
}

add_action("ast_front_footer", "include_ast_html_formatter_footer_script", 100);
function include_ast_html_formatter_footer_script(){
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.3/ace.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.3/mode-html.min.js"></script>';
    
    $version = filemtime( TOOLS_PATH . "html-decoder/main.js" );
    $scripturl = get_site_url() . sprintf("tools/html-decoder/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}