<?php

if( ! function_exists( "check_gzip" ) ){
    /**
     * Check GZIP Compression
     * 
     * @param string $url
     * @return object
     */
    function get_gzip( $url ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $response=curl_exec($ch);
        if (curl_errno($ch)) {
            return (object) array(
                "success" => false,
                "message" => curl_error($ch)
            );
        }

        $compressed_size = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $uncompressed_size = strlen($body);
        $gz_data_size = strlen(gzencode($body, 9));
        curl_close($ch);
    
        $isGzip = false;
        if(str_contains($header, "gzip"))
            $isGzip = true;
    
        $class = $isGzip ? "success" : "danger";
    
        $percentage = 0;
        if( $uncompressed_size > 0 ){
            if( $isGzip ){
                $percentage = round(((((int)$uncompressed_size - (int)$compressed_size) / (int)$uncompressed_size) * 100),1);
            }else{
                $percentage = round(((((int)$uncompressed_size - (int)$gz_data_size) / (int)$uncompressed_size) * 100),1);
            }
        }
            
        return (object) array(
            "success" => true,
            "domain" => extractHostname($url),
            "compressed_size" => format_size($compressed_size, 2),
            "uncompressed_size" => format_size($uncompressed_size, 2),
            "is_gzip" => $isGzip,
            "gz_data_size" => format_size($gz_data_size, 2),
            "class" => $class,
            "percentage" => $percentage,
            "header" => $header
        );
    }
}

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_check-gzip-compression", function($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Website Link", array(
        "btnlabel" => "Check Compression",
        "resultlabel" => "Result",
        "loadingmodal" => "Checking gZIP Compression. . ."
    ));
}, 10, 2);

/** RENDER TOOL MAIN SCRIPTS */
add_action("add_scripts", "include_tool_scripts");
function include_tool_scripts(){
    $scripturl = get_site_url() . "app/templates/downloader/main.js?v=1.0.1";
    add_js_script("toolscript", $scripturl);

    add_code_before_script("toolscript", 'const toolOptions={errormessage : "Unable to check gZIP compression. Please check link and try again!!!", loadingtext : "Checking"};');
}


/** HANDLE AJAX REQUEST: CHECK GZIP COMPRESSION */
add_action("ajax/req/process_check-gzip-compression_checker", "ajax_process_check_gzip_compression_checker");
add_action("ajax/req/nologin/process_check-gzip-compression_checker", "ajax_process_check_gzip_compression_checker");
function ajax_process_check_gzip_compression_checker(){
    if( isset( $_POST['link'] ) && filter_var($_POST['link'], FILTER_VALIDATE_URL) ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $result = get_gzip($_POST['link']);
            if( filter_var( $result->success, FILTER_VALIDATE_BOOLEAN ) ){
                ob_start();
                if( filter_var( $result->is_gzip, FILTER_VALIDATE_BOOLEAN ) ){
                    include TOOLS_PATH . "check-gzip-compression/result.php";
                }else{
                    include TOOLS_PATH . "check-gzip-compression/result_error.php";
                }
                
                ast_send_json(array(
                    "success" => true,
                    "message" => ob_get_clean(),
                    "data" => $result
                ));
            }

            ast_send_json($result);
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Please provide valid URL"
        ));
    }
}

add_action("tkp/api/check-gzip-compression", "tkp_check_gzip_compression_api");
function tkp_check_gzip_compression_api(){
    if( isset($_REQUEST['url']) && filter_var($_REQUEST['url'], FILTER_VALIDATE_URL) ){
        $url = trim($_REQUEST['url']);

        $result = get_gzip($url);
        if( filter_var( $result->success, FILTER_VALIDATE_BOOLEAN ) ){
            unset($result->header);
            unset($result->class);
        }

        ast_send_json($result);
    }

    ast_send_json(array(
        "success" => false,
        "message" => "Please provide valid URL"
    ));
}