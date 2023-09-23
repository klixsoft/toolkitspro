<?php

/** INCLUDE TOOL CONTENTS */
add_action("ast_tool_content_find-dns-records", "ast_render_dns_record_checker_tool_content", 10, 2);
function ast_render_dns_record_checker_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Check DNS Records",
        "name" => "url",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking DNS Record . . ."
    ));
}

/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_domain_dns_checker_script");
function include_domain_dns_checker_script(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Checking DNS Record . . .",
        "errormessage" => "Unable to check dns records. Please try again!!!"
    ))));
}

function ast_dns_record_render($type, $name, $ttl, $content){
    return sprintf('<tr>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
    </tr>', $type, $name, $ttl, $content);
}

function ast_dns_recoder_render_type( $data ){
    $output = '';
    if( !empty( $data ) ){
        foreach( $data as $k => $d ){
            if( isset( $d['type'] ) ){
                switch( $d['type'] ){
                    case "A":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['ip'] );
                        break;

                    case "NS":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['target'] );
                        break;
        
                    case "MX":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['target'] );
                        break;
        
                    case "TXT":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['txt'] );
                        break;
        
                    case "AAAA":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['ipv6'] );
                        break;

                    case "CNAME":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['target'] );
                        break;

                    case "SOA":
                        $output .= ast_dns_record_render( $d['type'], $d['host'], $d['ttl'], $d['mname'] . "<br />" . $d['rname'] );
                        break;
                }
            }
        }
    }

    return $output;
}

add_action("ajax/req/process_find-dns-records_checker", "ast_process_find_dns_records_checker");
add_action("ajax/req/nologin/process_find-dns-records_checker", "ast_process_find_dns_records_checker");
function ast_process_find_dns_records_checker(){
    if( isset( $_POST['url'] ) && !empty( $_POST['url'] ) ){
        if( filter_var( $_POST['url'], FILTER_VALIDATE_URL ) ){

            $valdation = validate_captcha();
            if( $valdation->success ){
                $domain = extractHostname($_POST['url']);
                $dnsinfo = dns_get_record($domain, DNS_ALL);
                $output = ast_dns_recoder_render_type($dnsinfo);

                if( empty( $output ) ){
                    ast_send_json(array(
                        "success" => false,
                        "message" => "Unable to get DNS Record for this domain.!!!"
                    ));
                }
                
                ob_start();
                include TOOLS_PATH . "find-dns-records/result.php";
                ast_send_json(array(
                    "success" => true,
                    "message" => ob_get_clean()
                ));
            }else{
                ast_send_json($valdation);
            }
        }else{
            ast_send_json(array(
                "success" => false,
                "message" => "Please provide valid URL!!!"
            ));
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "URL is Empty!!!"
        ));
    }
}