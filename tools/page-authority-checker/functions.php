<?php

if( ! function_exists( "handleSEOMoz" ) ){

    /**
     * handle SEO MOZ api
     * 
     * @param string $site
     * @param string $accessid
     * @param string $secretkey
     */
    function handleSEOMoz($site, $accessid, $secretkey){
        $URL='https://lsapi.seomoz.com/v2/url_metrics';
        $payload = json_encode(array(
            "targets" => [$site]
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$accessid:$secretkey");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $result = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);

        $results = json_decode($result);
        if( $status_code == 200 ){
            return (object) array(
                "success" => true,
                "pa" => $results->results[0]->page_authority,
                "da" => $results->results[0]->domain_authority
            );
        }else if( $status_code == 429 ){
            shift_apikey_and_update(array("moz_accessid", "moz_secretkey"));
        }
        
        return (object) array(
            "message" => @$results->message ?? "Unable to check Page Authority!!!",
            "success" => false
        );
    }
}

/** TOOL CONTENT */
add_action("ast_tool_content_page-authority-checker", "ast_render_page_authority_checker_tool_content", 10, 2);
function ast_render_page_authority_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Page Authority",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Page Authority . . ."
    ));
}

/** ADD TOOL SCRIPTS */
add_action("add_scripts", "include_texttohtml_ratio");
function include_texttohtml_ratio(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Check Page Authority . . .",
        "errormessage" => "Unable to check page authority. Please try again!!!"
    ))));
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_page-authority-checker_checker", "ast_process_page_authority_checker_checker");
add_action("ajax/req/nologin/process_page-authority-checker_checker", "ast_process_page_authority_checker_checker");
function ast_process_page_authority_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check page authority. Please try again!!!"
    );

    if( 
        isset( $_POST['link'] )
        && filter_var( $_POST['link'], FILTER_VALIDATE_URL )
    ){
        $accessid = get_apikey("moz_accessid");
        $secretkey = get_apikey("moz_secretkey");
        $url = trim($_POST['link']);

        if( !empty($accessid) && !empty($secretkey) ){

            $domain = extractHostname($url);
            $mozAPI = handleSEOMoz($domain, $accessid, $secretkey);
            if( $mozAPI->success ){
                ob_start();
                include TOOLS_PATH . "page-authority-checker/result.php";

                $output = array(
                    "success" => true,
                    "message" => ob_get_clean()
                );
            }else{
                $output = (array) $mozAPI;
            }
        }else{
            $output = array(
                "success" => false,
                "message" => "Please setup API Correctly!!!"
            );
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Please enter valid URL!!!"
        );
    }

    ast_send_json($output);
}