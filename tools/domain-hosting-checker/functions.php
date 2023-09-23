<?php

/** INCLUDE TOOL CONTENT */
add_action("ast_tool_content_domain-hosting-checker", "ast_render_hosting_checker_tool_content", 10, 2);
function ast_render_hosting_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Domain Hosting",
        "name" => "url",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Domain Hosting . . ."
    ));
}


/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_domain_hosting_checker_script");
function include_domain_hosting_checker_script(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking Domain Hosting . . .",
        "errormessage" => "Unable to check domain hosting. Please try again!!!"
    ))));
}

add_action("ajax/req/process_domain-hosting-checker_checker", "ast_process_domain_hosting_checker_checker");
add_action("ajax/req/nologin/process_domain-hosting-checker_checker", "ast_process_domain_hosting_checker_checker");
function ast_process_domain_hosting_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check hosting for this domain. Please try again!!!"
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
                    include TOOLS_PATH . "domain-hosting-checker/result.php";
                    $output = array(
                        "success" => true,
                        "message" => ob_get_clean()
                    );
                }else{
                    throw new \Exception("Unable to check hosting for this domain!!!");
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