<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_word-counter", "include_ascii_tool_template", 10, 2);
function include_ascii_tool_template($tool, $report){
    include TOOLS_PATH . $tool->extra . "/template.php";
}

/** RENDER TOOL MAIN SCRIPTS */
add_action("add_scripts", "include_ascii_art_scripts");
function include_ascii_art_scripts(){
    add_js_script("toolscript", get_site_url("tools/word-counter/main.js?v=1.0.1"));
}