<?php

add_action("ast_tool_content_youtube-tag-generator", "ast_render_yt_tag_gen_tool_content", 10, 2);
function ast_render_yt_tag_gen_tool_content($tool, $report){
    require_once TOOLS_PATH . "youtube-tag-generator/template.php";
}

add_action("ast_front_footer", "include_ast_yt_tag_gen_footer_script", 100);
function include_ast_yt_tag_gen_footer_script(){
    $version = filemtime( TOOLS_PATH . "youtube-tag-generator/main.js" );
    $scripturl = get_site_url() . sprintf("tools/youtube-tag-generator/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}

add_action("ajax/req/process_youtube_tag_generator_checker", "ast_tool_process_youtube_tag_generator_checker");
add_action("ajax/req/nologin/process_youtube_tag_generator_checker", "ast_tool_process_youtube_tag_generator_checker");
function ast_tool_process_youtube_tag_generator_checker(){
    if( isset( $_POST['keyword'] ) && !empty($_POST['keyword']) ){

        $valdation = (object) apply_filters("ast/before/ajax/req", array(
            "success" => true,
            "message" => ""
        ));
        if( filter_var($valdation->success, FILTER_VALIDATE_BOOLEAN) ){
            
            $lang = isset($_POST['lang']) ? $_POST['lang'] : "en";

            include TOOLS_PATH . "youtube-tag-generator/youtubeTagGenerator.php";
            $result = (new \Tool\youtubeTagGenerator($lang, trim($_POST['keyword'])))->get();
            
            if( isset($result['success']) && filter_var($result['success'], FILTER_VALIDATE_BOOLEAN) ){
                
                $output = $result['message'];
                ob_start();
                include TOOLS_PATH . "youtube-tag-generator/result.php";
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
            "message" => "Keyword is missing!!!"
        ));
    }
}