<?php

if( ! function_exists( "get_social_status_record" ) ){

    function search_social_status($regex, $html){
        $link = $user = "";

        preg_match_all($regex, $html, $matches);
        if( isset( $matches[1] ) && !empty( $matches[1][0] ) ){
            $link = $matches[0][0];
            $user = $matches[1][0];
        }

        return (object) array(
            "link" => $link,
            "user" => $user
        );
    }

    function get_whatsappid_from_url($url, $default){
        if( filter_var($default, FILTER_VALIDATE_URL) || str_contains($default, "phone") ){
            $url_components = parse_url($url); 
            if( isset( $url_components['query'] ) && !empty( $url_components['query'] ) ){
                parse_str($url_components['query'], $params);
                if( isset( $params['phone'] ) ){
                    return $params['phone'];
                }
            }
        }
        return $default;
    }

    /**
     * Get social records
     */
    function get_social_status_record($url){
        $html = url_get_contents($url);

        $matches = array();

        $fbuser = $twiuser = $instauser = $pinterestuser = $ytuser = $tiktokuser = $whatsappuser = '';
        $fbLink = $twiLink = $instaLink = $pinterestLink = $ytlink = $tiktoklink = $whatsapplink = '';

        $fbMatch = '#https?\://(?:www\.)?(?:facebook|fb)\.[a-zA-Z]{1,6}/(\d+|[A-Za-z0-9\.]+)/?#';
        $twiMatch = '#https?\://(?:www\.)?twitter\.[a-zA-Z]{1,6}/(\d+|[A-Za-z0-9\.]+)/?#';
        $instaMatch = '#https?\://(?:www\.)?instagram\.[a-zA-Z]{1,6}/(\d+|[A-Za-z0-9\.]+)/?#';
        $pinterestMatch = '#https?\://(?:www\.)?pinterest\.[a-zA-Z]{1,6}/(\d+|[A-Za-z0-9\.]+)/?#';
        $ytchannemmatch = '#(?:https?:)?\/\/(?:[A-z]+\.)?youtube.com\/channel\/([A-z0-9-\_]+)\/?#';
        $ytusermatch = '#(?:https?:)?\/\/(?:[A-z]+\.)?youtube.com\/([@A-z0-9-\_]+)\/?#';
        $whatsappmatch = '#https?\://(?:www|api\.)?(?:whatsapp|wa)\.[a-zA-Z]{1,6}(?:\/send)?\/([A-Za-z0-9\?\=]+)#';
        $tiktokmatch = '#(?:https?:)?\/\/(?:[A-z]+\.)?tiktok.com\/([@A-z0-9-\_]+)\/?#';

        
        /** FACEBOOK MATCH */
        $fbData = array();
        preg_match_all($fbMatch, $html, $matches);
        if(isset($matches[1])){
            if(isset($matches[1][0]) && $matches[1][0] != ''){
                if($matches[1][0] === 'sharer'){
                    if(isset($matches[1][1])){
                        $fbData = (object) array(
                            "link" => $matches[0][1],
                            "user" => $matches[1][1]
                        );
                    }
                }else{
                    $fbData = (object) array(
                        "link" => $matches[0][0],
                        "user" => $matches[1][0]
                    );
                }
            }
        }
    
        /** TWIITER MATCH */
        $twitterData = search_social_status($twiMatch, $html);
    
        /** INSTAGRAM MATCH */
        $instaData = search_social_status($instaMatch, $html);

        /** PINTEREST MATCH */
        $pinterestData = search_social_status($pinterestMatch, $html);

        /** YOUTUBE MATCH */
        $ytData = search_social_status($ytchannemmatch, $html);
        if( empty( $ytData->link ) ){
            $ytData = search_social_status($ytusermatch, $html);
        }

        /**TIKTOK DATA */
        $tktokData = search_social_status($tiktokmatch, $html);

        /** WHATSAPP MATHC */
        $whatsappData = array();
        preg_match_all($whatsappmatch, $html, $matches);
        if( isset( $matches[1] ) && !empty( $matches[1][0] ) ){
            $whatsappData = (object) array(
                "link" => $matches[0][0],
                "user" => get_whatsappid_from_url($matches[0][0], $matches[1][0])
            );
        }

    
        return (object) array(
            'facebook' => $fbData, 
            'twitter' => $twitterData, 
            'instagram' => $instaData,
            'youtube' => $ytData,
            'whatsapp' => $whatsappData,
            'tiktok' => $tktokData,
            "pinterest" => $pinterestData
        );
    }

}

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_social-stats-checker", function($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Website Link", array(
        "btnlabel" => "Check Social Status",
        "resultlabel" => "Social Status Result",
        "loadingmodal" => "Checking Social Status . . ."
    ));
}, 10, 2);

/** RENDER TOOL MAIN SCRIPTS */
add_action("add_scripts", "include_social_stat_tool_scripts");
function include_social_stat_tool_scripts(){
    add_js_script("toolscript", get_site_url("app/templates/downloader/main.js"));
    add_code_after_script("toolscript", 'const toolOptions={errormessage : "Unable to check Social Status. Please check link and try again!!!"};');
}

/** HANDLE AJAX REQUEST: CHECK GZIP COMPRESSION */
add_action("ajax/req/process_social-stats-checker_checker", "ajax_process_social_stats_checker_checker");
add_action("ajax/req/nologin/process_social-stats-checker_checker", "ajax_process_social_stats_checker_checker");
function ajax_process_social_stats_checker_checker(){
    if( isset( $_POST['link'] ) && filter_var($_POST['link'], FILTER_VALIDATE_URL) ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            $result = get_social_status_record($_POST['link']);
            if( !empty( $result ) ){
                ob_start();
                include TOOLS_PATH . "social-stats-checker/result.php";
                ast_send_json(array(
                    "success" => true,
                    "message" => ob_get_clean(),
                    "data" => $result
                ));
            }          
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Please provide valid URL!!!"
        ));
    }
}