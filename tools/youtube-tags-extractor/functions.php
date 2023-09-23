<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_youtube-tags-extractor", function($tool, $report){
    echo '<style>body .video_downloader .la-copy{left: -34%;}</style>';
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Youtube Video Link", array(
        "btnlabel" => "Get Video Tags",
        "resultlabel" => "Video Tags Result:"
    ));
}, 10, 2);


/** RENDER TOOL MAIN SCRIPTS */
add_action("ast_front_footer", "include_ast_yt_tag_ext_footer_script", 100);
function include_ast_yt_tag_ext_footer_script(){
    $version = filemtime( TOOLS_PATH . "youtube-tags-extractor/main.js" );
    $scripturl = get_site_url() . sprintf("tools/youtube-tags-extractor/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}



/** HANDLE AJAX REQUEST: YOUTUBE HASH TAGS EXTRACTOR */
add_action("ajax/req/process_youtube-tags-extractor_checker", "ajax_process_youtube_tags_extractor_checker");
add_action("ajax/req/nologin/process_youtube-tags-extractor_checker", "ajax_process_youtube_tags_extractor_checker");
function ajax_process_youtube_tags_extractor_checker(){
    if( isset( $_POST['toolid'] ) && intval($_POST['toolid']) > 0 ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){

            $link = isset($_POST['link']) ? $_POST['link'] : "";

            $apikey = get_apikey("youtubeapi");
            if( empty( $apikey ) ){
                ast_send_json(array(
                    "success" => false,
                    "message" => "API Key is missing!!!"
                ));
            }

            include TOOLS_PATH . "youtube-tags-extractor/youtubeTagExtractor.php";
            $result = (new \Tool\youtubeTagExtractor($apikey, $link))->get();
            
            if( isset($result['success']) && filter_var($result['success'], FILTER_VALIDATE_BOOLEAN) ){
                
                $output = $result['message'];
                ob_start();
                include TOOLS_PATH . "youtube-tags-extractor/result.php";
                $content = ob_get_clean();

                ast_send_json(array(
                    "success" => true,
                    "message" => $content
                ));
            }else{
                ast_send_json($result);
            }
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Tool ID is missing. Please refresh the page and try again!!!"
        ));
    }
}