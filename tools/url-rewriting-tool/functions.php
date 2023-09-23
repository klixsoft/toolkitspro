<?php

if( ! function_exists( "urlrewrite_split_url" ) ){
    /**
     * Split URL in Query and Values
     * 
     * @param string $url
     * 
     * @return array
     */
    function urlrewrite_split_url($url){
        $url = htmlspecialchars_decode($url);
        $arr = parse_url($url);
        $arg_arr = explode("&", $arr['query']);
        $file_arr = explode("/", $arr['path']);
    
        foreach ($file_arr as $val){
            $filename = $val;
        }
    
        $file_without = explode(".", $filename);
        $file_without = $file_without[0];
    
        foreach ($arg_arr as $val){
            $arg[] = explode("=", $val);
        }
    
        return array( $filename, $file_without, $arg);
    }
}

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_url-rewriting-tool", function($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Website Link", array(
        "btnlabel" => "Rewrite URL",
        "resultlabel" => "Result",
        "loadingmodal" => "Rewriting URL . . .",
        "afterinput" => '<em class="text-muted">Eg: http://www.domain.com/test.php?categoryid=1&amp;productid=10</em>',
        "iconleft" => "-40%"
    ));
}, 10, 2);


/** RENDER TOOL MAIN SCRIPTS */
add_action("add_scripts", "include_url_rewriter_scripts");
function include_url_rewriter_scripts(){
    add_js_script("toolscript", get_site_url("app/templates/downloader/main.js"));
    add_code_before_script("toolscript", 'const toolOptions={errormessage : "Unable to check HTTP Headers. Please check link and try again!!!", loadingtext : "Checking"};');
}

/** HANDLE AJAX REQUEST: URL REWRITING TOOL */
add_action("ajax/req/process_url-rewriting-tool_checker", "ajax_process_url_rewriting_tool_checker");
add_action("ajax/req/nologin/process_url-rewriting-tool_checker", "ajax_process_url_rewriting_tool_checker");
function ajax_process_url_rewriting_tool_checker(){
    $output = array(
        "success" => false,
        "message" => "Please provide valid URL!!!"
    );

    if( isset( $_POST['link'] ) && filter_var($_POST['link'], FILTER_VALIDATE_URL) ){
        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $url = trim($_POST['link']);
            $r_1 = $r_2 = $r_3 = "";    

            if( check_url_has_query( $url ) ){
                $arr = parse_url( $url );
                $example_url = $arr['scheme']."://".$arr['host'].$arr['path'];

                $arr_val = urlrewrite_split_url( $url );
                $filename= trim($arr_val[0]);
                $f_without_e = trim($arr_val[1]);
                $parsed_arg = $arr_val[2];
                $start = 1;

                $sht_url = str_replace($filename,"",$example_url);
                $sht_url=$sht_url.$f_without_e;
                $dht_ex_url = $dht_url = $sht_ex_url = $sht_url;

                foreach($parsed_arg as $argf => $value)
                {
                    if ($start == 1){ $syb = "?";}else {$syb = "&";}
                    $sht_url = $sht_url."-".$value[0]."-".$value[1];
                    $dht_url = $dht_url."/".$value[0]."/".$value[1];
                    $dht_ex_url = $dht_ex_url."/".$value[0]."/(Any Value)";
                    $sht_ex_url = $sht_ex_url."-".$value[0]."-(Any Value)";
                    $r_1 = $r_1."-$value[0]-(.*)";
                    $r_2 = $r_2.$syb."$value[0]=$$start";
                    $r_3 = $r_3."/$value[0]/(.*)";
                    $start++;
                }

                $sht_url = trim($sht_url).".htm";
                $dht_url = trim($dht_url)."/";
                $sht_ex_url = trim($sht_ex_url).".htm";
                $dht_ex_url = trim($dht_ex_url)."/";
                $sht_data =  "Options +FollowSymLinks\r\nRewriteEngine on\r\nRewriteRule $f_without_e".trim($r_1)."\.htm$ $filename".trim($r_2);
                $dht_data = "Options +FollowSymLinks\r\nRewriteEngine on\r\nRewriteRule $f_without_e".trim($r_3)."/ $filename".trim($r_2)."\r\nRewriteRule $f_without_e".trim($r_3)." $filename".trim($r_2);

                ob_start();
                include TOOLS_PATH . "url-rewriting-tool/result.php";
                $content = ob_get_clean();

                ast_send_json(array(
                    "success" => true,
                    "message" => $content
                ));
            }else{
                $output = array(
                    "success" => false,
                    "message" => "URL entered does not seem to be a dynamic URL!!!"
                );
            }
        }else{
            $output = $valdation;
        }
    }

    ast_send_json($output);
}