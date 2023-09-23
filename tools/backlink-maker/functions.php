<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_backlink-maker", function($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Make Backlink",
        "resultlabel" => "Result"
    ));
}, 10, 2);


/** DOWNLOADER FIELD DEFAULT OUTPUT */
add_action("downloader/field/output/backlink-maker", function(){
    include TOOLS_PATH . "backlink-maker/output.php";
});


/** INCLUDE TOOL SCRIPTS */
add_action("add_scripts", "include_backlink_maker_script");
function include_backlink_maker_script(){
    $scripturl = get_site_url("tools/backlink-maker/main.js");
    add_js_script("toolscript", $scripturl);
}


/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_create_backlink", "ast_process_create_backlink");
add_action("ajax/req/nologin/process_create_backlink", "ast_process_create_backlink");
function ast_process_create_backlink(){
    if( 
        isset( $_POST['url'] )
        && filter_var( $_POST['url'], FILTER_VALIDATE_URL )
    ){
        $url = trim($_POST['url']);
        try {
            getSimpleRequest($url);
            ast_send_json(array( "success" => true ));
        } catch (\Throwable $th) {
            
        } catch (\Exception $th) {
            
        }
    }

    ast_send_json(array( "success" => false ));
}