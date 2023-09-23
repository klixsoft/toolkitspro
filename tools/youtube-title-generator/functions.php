<?php

add_action("ast_tool_content_youtube-title-generator", "ast_render_yt_title_gen_tool_content", 10, 2);
function ast_render_yt_title_gen_tool_content($tool, $report){
    require_once TOOLS_PATH . "youtube-title-generator/template.php";
}

add_action("ast_front_footer", "include_ast_yt_title_gen_footer_script", 100);
function include_ast_yt_title_gen_footer_script(){
    $version = filemtime( TOOLS_PATH . "youtube-title-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/youtube-title-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}

add_action("ajax/req/process_youtube_title_generator_checker", "ast_tool_process_youtube_title_generator_checker");
add_action("ajax/req/nologin/process_youtube_title_generator_checker", "ast_tool_process_youtube_title_generator_checker");
function ast_tool_process_youtube_title_generator_checker(){
    if( isset( $_POST['toolid'] ) && intval($_POST['toolid']) > 0 ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){

            $country = isset($_POST['country']) ? $_POST['country'] : "us";
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "s";

            $apikey = get_apikey("youtubeapi");
            if( empty( $apikey ) ){
                ast_send_json(array(
                    "success" => false,
                    "message" => "API Key is missing!!!"
                ));
            }

            include TOOLS_PATH . "youtube-title-generator/youtubeTitleGenerator.php";
            $result = (new \Tool\youtubeTitleGenerator(array(
                "api" => $apikey,
                "country" => $country,
                "keyword" => $keyword
            )))->get();
            
            if( isset($result['success']) && filter_var($result['success'], FILTER_VALIDATE_BOOLEAN) ){
                
                $output = $result['message'];
                ob_start();
                include TOOLS_PATH . "youtube-title-generator/result.php";
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