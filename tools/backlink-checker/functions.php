<?php

if( ! function_exists( "handleSEOMoz_Backlink" ) ){
    /**
     * Check backlink using moz api
     */
    function handleSEOMoz_Backlink($site, $accessid, $secretkey, $scope="root_domain", $limit=50){
        $URL='https://lsapi.seomoz.com/v2/links';
        $payload = json_encode(array(
            "target" => $site,
            "target_scope" => $scope,
            "limit" => $limit
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
            if( property_exists($results, "results") ){
                $totalBacklinks = 0;
                $linkingWebsite = 0;
                $domainAuthority = 0;
                $links = [];
                
                foreach( $results->results as $key => $link ){
                    if( $key == 0 ){
                        $domainAuthority = $link->target->domain_authority;
                        $linkingWebsite = $link->target->root_domains_to_root_domain;
                        $totalBacklinks = $link->target->pages_to_root_domain;
                    }

                    $links[] = (object) array(
                        "target" => (object) array(
                            "text" => $link->anchor_text,
                            "link" => "https://" . $link->target->page
                        ),
                        "source" => (object) array(
                            "text" => $link->source->title,
                            "link" => "https://" . $link->source->page,
                            "da" => $link->source->domain_authority
                        )
                    );
                }

                return (object) array(
                    "success" => true,
                    "totalBacklinks" => $totalBacklinks,
                    "linkingWebsite" => $linkingWebsite,
                    "domainAuthority" => $domainAuthority,
                    "links" => $links
                );
            }
        }else if( $status_code == 429 ){
            shift_apikey_and_update(array("moz_accessid", "moz_secretkey"));
        }
        
        return (object) array(
            "message" => @$results->message ?? "Unable to check backlink!!!",
            "success" => false
        );
    }
}

/** TOOL CONTENT */
add_action("ast_tool_content_backlink-checker", "ast_render_backlink_checker_tool_content", 10, 2);
function ast_render_backlink_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check Backlink",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking Backlink . . .",
        "iconleft" => "-32%"
    ));
}

/** ADD TOOL SCRIPTS */
add_action("add_scripts", "include_texttohtml_ratio");
function include_texttohtml_ratio(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking Backlink  . . .",
        "errormessage" => "Unable to check backlink. Please try again!!!"
    ))));
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_backlink-checker_checker", "ast_process_backlink_checker_checker");
add_action("ajax/req/nologin/process_backlink-checker_checker", "ast_process_backlink_checker_checker");
function ast_process_backlink_checker_checker(){
    $output = array(
        "success" => false,
        "message" => "Unable to check backlink. Please try again!!!"
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
            $mozAPI = handleSEOMoz_Backlink($domain, $accessid, $secretkey);
            if( $mozAPI->success ){
                ob_start();
                include TOOLS_PATH . "backlink-checker/result.php";

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