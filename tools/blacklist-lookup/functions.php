<?php
add_action("ast_tool_content_blacklist-lookup", "ast_render_blacklist_lookup_tool_content", 10, 2);
function ast_render_blacklist_lookup_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Blacklist",
        "name" => "url",
        "resultlabel" => "Result"
    ));
}

add_action("downloader/field/output/blacklist-lookup", function(){
    require_once TOOLS_PATH . "blacklist-lookup/result.php";
});

add_action("ast_front_footer", "include_ast_blacklist_lookup_footer_script", 100);
function include_ast_blacklist_lookup_footer_script(){
    $version = filemtime( TOOLS_PATH . "blacklist-lookup/main.js" );
    $scripturl = get_site_url() . sprintf("tools/blacklist-lookup/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}

add_action("ajax/req/process_create_blacklist", "ast_process_create_blacklist");
add_action("ajax/req/nologin/process_create_blacklist", "ast_process_create_blacklist");
function ast_process_create_blacklist(){
    $output = array(
        "success" => false,
        "message" => "Unable to check Blacklist. Please try again!!!"
    );
    if( 
        isset( $_POST['url'] )
        && filter_var( $_POST['url'], FILTER_VALIDATE_URL )
    ){
        try {
            $host = $_POST['dns'];
            $domainname = get_domain_from_url($_POST['url']);
            $getHostIP = gethostbyname($host);
            $reverse_ip = implode(".", array_reverse(explode(".", $getHostIP)));
            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
                $output = array(
                    "success" => true,
                    "message" => "Listed"
                );
            }else{
                $output = array(
                    "success" => false,
                    "message" => "Not Listed"
                );
            }
        } catch (\Throwable $th) {
            $output = array(
                "success" => false,
                "message" => $th->getMessage()
            );
        } catch (\Exception $th) {
            $output = array(
                "success" => false,
                "message" => $th->getMessage()
            );
        }
    }

    echo json_encode($output);
    die();
}