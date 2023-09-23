<?php

add_action("ast_tool_content_{{SLUG}}", function($tool, $report){
    $Imagefrom = "{{from}}";
    $Imageto = "{{to}}";
    $ImageAccept = "image/{{from}}";
    $SupportTitle = "{{fromc}}";

    $template = TOOLS_PATH . "image-converter/convert.php";
    if( file_exists( $template ) ){
        include $template;
    }else{
        echo bs_alert("Unable to load <strong>{{fromc}} to {{toc}} Converter</strong> tool. Please refresh the page!!!", "danger");
    }
}, 10, 2);

add_action("ast_front_footer", function(){
    echo sprintf('<script src="%s"></script>', get_site_url("tools/image-converter/main.js"));
}, 100);