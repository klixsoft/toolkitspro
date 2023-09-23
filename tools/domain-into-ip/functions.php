<?php
/** INCLUDE TOOL CONTENT */
add_action("ast_tool_content_domain-into-ip", "ast_render_domain_to_ip_tool_content", 10, 2);
function ast_render_domain_to_ip_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Domain IP",
        "name" => "url",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Domain IP . . ."
    ));
}

/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_domain_ip_checker_script");
function include_domain_ip_checker_script(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking Domain IP . . .",
        "errormessage" => "Unable to check domain ip. Please try again!!!"
    ))));
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_domain-into-ip_checker", "ast_process_domain_into_ip_checker");
add_action("ajax/req/nologin/process_domain-into-ip_checker", "ast_process_domain_into_ip_checker");
function ast_process_domain_into_ip_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check Keyword Density. Please try again!!!"
    );
    if( 
        isset( $_POST['url'] )
        && filter_var( $_POST['url'], FILTER_VALIDATE_URL )
    ){
        try {
            $response = validate_captcha();
            if( $response->success ){
                $domain = extractHostname(trim($_POST['url']), true);
                $ipApi = new \AST\Helper\IpApi();
                $info = $ipApi->parse($domain);
                if( !empty( $info ) ){
                    ob_start();
                    include TOOLS_PATH . "domain-into-ip/result.php";
                    $output = array(
                        "success" => true,
                        "message" => ob_get_clean()
                    );
                }else{
                    throw new \Exception("Unable to check your domain's IP!!!");
                }
            }else{
                throw new \Exception($response->message);
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

    ast_send_json($output);
}