<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_adsense-calculator", function($tool, $report){
    include TOOLS_PATH . "adsense-calculator/template.php";
}, 10, 2);


/** RENDER TOOL MAIN SCRIPTS */
add_action("ast_front_footer", function(){
    $version = filemtime( TOOLS_PATH . "adsense-calculator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/adsense-calculator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}, 100);