<?php

add_action("ast_tool_content_json-to-xml-converter", "ast_render_json_to_xml_tool_content", 10, 2);
function ast_render_json_to_xml_tool_content($tool, $report){
    require_once TOOLS_PATH . "json-to-xml-converter/template.php";
}

add_action("ast_front_header", "include_ast_json_to_xml_header_script", 100);
function include_ast_json_to_xml_header_script(){
    echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.0/jsoneditor.min.css" rel="stylesheet" />';
}

add_action("ast_front_footer", "include_ast_json_to_xml_footer_script", 100);
function include_ast_json_to_xml_footer_script(){
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.0/jsoneditor.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/x2js/1.2.0/xml2json.min.js"></script>';

    $version = filemtime( TOOLS_PATH . "json-to-xml-converter/main.js" );
    $scripturl = get_site_url() . sprintf("tools/json-to-xml-converter/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}