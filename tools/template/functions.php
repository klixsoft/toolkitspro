<?php

add_action("ast_tool_content_{{TOOL_SLUG}}", function($tool, $report){
    require_once TOOLS_PATH . "{{TOOL_SLUG}}/template.php";
}, 10, 2);

add_action("ast_front_footer", function(){
    $version = filemtime( TOOLS_PATH . "{{TOOL_SLUG}}/main.js" );
    $scripturl = get_site_url() . sprintf("tools/{{TOOL_SLUG}}/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}, 100);