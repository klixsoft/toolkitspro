<?php

/** INCLUDE TOOL TEMPLATE/CONTENT */
add_action("ast_tool_content_robots-txt-generator", "ast_render_robots_txt_tool_content", 10, 2);
function ast_render_robots_txt_tool_content($tool, $report){
    require_once TOOLS_PATH . "robots-txt-generator/template.php";
}

/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_robots_scripts");
function include_robots_scripts(){
    add_js_script("toolscript", get_site_url("tools/robots-txt-generator/main.js"));
}