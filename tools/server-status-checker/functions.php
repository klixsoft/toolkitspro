<?php
add_action("ast_tool_content_server-status-checker", "ast_render_server_status_checker_tool_content", 10, 2);
function ast_render_server_status_checker_tool_content($tool, $report){
    require_once TOOLS_PATH . "server-status-checker/template.php";
}

add_action("add_scripts", "include_ast_server_status_checker_footer_script", 100);
function include_ast_server_status_checker_footer_script(){
    $version = filemtime( TOOLS_PATH . "server-status-checker/main.js" );
    $scripturl = get_site_url() . sprintf("tools/server-status-checker/main.js?ver=%d", $version);
    add_js_script("toolscript", $scripturl);
}

add_action("ajax/req/process_server_status_checker_checker", "ast_process_server_status_checker_checker");
add_action("ajax/req/nologin/process_server_status_checker_checker", "ast_process_server_status_checker_checker");
function ast_process_server_status_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check Keyword Density. Please try again!!!"
    );
    if( 
        isset( $_POST['url'] )
        && filter_var( $_POST['url'], FILTER_VALIDATE_URL )
    ){
        try {
            $ch = curl_init( trim($_POST['url']) );
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $httpmessage = "";
            if( $httpcode >= 100 && $httpcode < 200 ){
                $httpmessage = sprintf('<span class="badge bg-%s">%s</badge>', "info", "Informational Responses");
            }else if( $httpcode >= 200 && $httpcode < 300 ){
                $httpmessage = sprintf('<span class="badge bg-%s">%s</badge>', "success", "Page Exists");
            }else if( $httpcode >= 300 && $httpcode < 400 ){
                $httpmessage = sprintf('<span class="badge bg-%s">%s</badge>', "warning", "Page Redirecting");
            }else if( $httpcode >= 400 && $httpcode < 500 ){
                $httpmessage = sprintf('<span class="badge bg-%s">%s</badge>', "danger", "Page Not Found");
            }else if( $httpcode >= 500 && $httpcode < 600 ){
                $httpmessage = sprintf('<span class="badge bg-%s">%s</badge>', "danger", "Server error");
            }

            $output = array(
                "success" => true,
                "code" => $httpcode,
                "remark" => $httpmessage
            );
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