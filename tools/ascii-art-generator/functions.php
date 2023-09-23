<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_ascii-art-generator", "include_ascii_tool_template", 10, 2);
function include_ascii_tool_template($tool, $report){
    include TOOLS_PATH . $tool->extra . "/template.php";
}

/** RENDER TOOL MAIN SCRIPTS */
add_action("add_scripts", "include_ascii_art_scripts");
function include_ascii_art_scripts(){
    add_js_script("figlet", get_site_url("tools/ascii-art-generator/assets/js/figlet.js"));
    add_js_script("aolfont", get_site_url("tools/ascii-art-generator/assets/js/aolfont.js"));
    add_js_script("toolscript", get_site_url("tools/ascii-art-generator/assets/js/main.js"));
}