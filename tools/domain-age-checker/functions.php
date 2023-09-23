<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_domain-age-checker", "ast_render_domain_age_checker_tool_content", 10, 2);
function ast_render_domain_age_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Domain Age",
        "name" => "url",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Domain Age . . ."
    ));
}

/** INCLUDE TOOL SCRIPT TO FOOTER */
add_action("add_scripts", "include_domain_age_checker_scrits");
function include_domain_age_checker_scrits(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking Domain Age . . .",
        "errormessage" => "Unable to check domain age. Please try again!!!"
    ))));
}


/** HANDLE TOOL AJAX REQUEST */
add_action("ajax/req/process_domain-age-checker_checker", "ast_process_domain_age_checker_checker");
add_action("ajax/req/nologin/process_domain-age-checker_checker", "ast_process_domain_age_checker_checker");
function ast_process_domain_age_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check Domain Age. Please try again!!!"
    );
    if( 
        isset( $_POST['url'] )
        && filter_var( $_POST['url'], FILTER_VALIDATE_URL )
    ){
        try {
            $response = validate_captcha();
            if( $response->success ){
                $domainAge = new \AST\Helper\DomainAge();
                $domain = extractHostname(trim($_POST['url'])); 
                $info = $domainAge->parse($domain);
                if( !empty( $info ) ){
                    $expired = empty( $info['content']['expiry'] ) ? true : false;
                    $domainAge = (object) array(
                        "url" => $domain,
                        "data" => $info,
                        "domainage" => $expired ? "May be Expired" : $info['content']['age'],
                        "createddate" => $expired ? "May be Expired" : $info['content']['created'],
                        "updatedate" => $expired ? "May be Expired" : $info['content']['updated'],
                        "expirydate" => $expired ? "May be Expired" : $info['content']['expiry'],
                        "expireafter" => $expired ? "May be Expired" : $info['content']['expireafter']
                    );

                    ob_start();
                    include TOOLS_PATH . "domain-age-checker/result.php";

                    $output = array(
                        "success" => true,
                        "message" => ob_get_clean()
                    );
                }else{
                    throw new \Exception("Unable to check for this domain!!!");
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