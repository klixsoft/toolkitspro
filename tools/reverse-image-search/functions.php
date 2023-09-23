<?php

add_action("ast_tool_content_reverse-image-search", function($tool, $report){
    require_once TOOLS_PATH . "reverse-image-search/template.php";
}, 10, 2);

add_action("ast_front_footer", function(){
    $version = filemtime( TOOLS_PATH . "reverse-image-search/main.js" );
    $scripturl = get_site_url() . sprintf("tools/reverse-image-search/main.js?ver=%d", $version);
    echo sprintf('<script src="%s"></script>', $scripturl);
}, 100);

add_action("ajax/req/reverse_image_search", "toolkitspro_reverse_image_search");
add_action("ajax/req/nologin/reverse_image_search", "toolkitspro_reverse_image_search");
function toolkitspro_reverse_image_search(){
    if( isset( $_FILES['file'] ) && !empty( $_FILES['file'] ) ){

        /** UPLOAD IMAGE FILE */
        $reserveImage = (new \AST\Tempdir("reverse-image-search"))->setup()->upload($_FILES['file']);
        $getFile = $reserveImage->getFile();
        if( $getFile && file_exists( $getFile ) ){
            $fileurl = $reserveImage->getFileURL() . $reserveImage->file;
            
            $output = '';
            $searchEngines = array(
                "google" => "https://lens.google.com/uploadbyurl?url={{URL}}",
                "bing" => "https://www.bing.com/images/searchbyimage?FORM=IRSBIQ&cbir=sbi&imgurl={{URL}}",
                "yandex" => "https://yandex.com/images/search?source=collections&&url={{URL}}",
                "tineye" => "https://www.tineye.com/search/?&url={{URL}}",
                "sogou" => "https://pic.sogou.com/ris?flag=1&drag=0&query={{URL}}",
                "baidu" => "https://graph.baidu.com/details?isfromtusoupc=1&tn=pc&carousel=0&image={{URL}}"
            );
            foreach($searchEngines as $engine => $url){
                $url = str_replace("{{URL}}", $fileurl, $url);
                $engineTitle = ucfirst($engine);
                $imageurl = get_site_url() . "tools/reverse-image-search/images/$engine.svg";
                $output .= sprintf('<div class="col-sm-6 col-12">
                    <div class="imgsearch_card">
                        <img src="%s" alt="%s Logo">

                        <div class="imgsearch_content">
                            <p>Images that are similar with your provided image according to <span>%s</span></p>
                            <a href="%s" class="btn btn-primary btn-sm" class="revs_btn" target="_blank">Show Matches</a>
                        </div>
                    </div>
                </div>', $imageurl, $engineTitle, $engineTitle, $url);
            }

            ast_send_json(array(
                "success" => true,
                "message" => $output
            ));
        }else{
            ast_send_json(array(
                "success" => true,
                "message" => bs_alert("Unable to upload image. Please try again!!!", "danger")
            ));
        }
    }

    ast_send_json(array(
        "success" => true,
        "message" => bs_alert("Please upload image files!!!", "danger")
    ));
}