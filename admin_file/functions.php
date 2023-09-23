<?php

use AST\FileSystem;

add_action("ast/before/delete/data/", function($from, $id){
    if( $from == 'posts' ){
        $post = get_post_by("id", $id);

        if( !empty( $post ) ){
            $folder = TOOLS_PATH . $post->slug . "/";
            return FileSystem::delete($folder, true);
        }
    }
}, 10, 2);


add_action("admin_header", "allsmarttools_admin_header_favicon");
add_action("ast_front_header", "allsmarttools_admin_header_favicon");
function allsmarttools_admin_header_favicon(){
    $settings = get_settings("basic");
    $fileurl = '';
    if( $settings ){
        $fileurl = @$settings->favicon_image;
    }

    if( ! filter_var( $fileurl, FILTER_VALIDATE_URL ) ){
        $fileurl = get_site_url() . "admin_file/assets/img/favicon.svg";
    }

    $htmlcode = '<link rel="icon" href="{{URL}}" type="{{TYPE}}" {{OTHERATTS}}>
    <link rel="alternate icon" href="{{URL}}" type="{{TYPE}}" {{OTHERATTS}}>';
    $fileext = FileSystem::extension($fileurl);
    
    $sizes = "";
    $type = "image/$fileext";
    if( $fileext == 'svg' ){
        $type = "image/svg+xml";
        $sizes = 'sizes="any"';
    }else if( $fileext == 'ico' ){
        $type = "image/x-icon";
    }

    echo str_replace(array(
        "{{URL}}",
        "{{TYPE}}",
        "{{OTHERATTS}}"
    ), array(
        $fileurl,
        $type,
        $sizes
    ), $htmlcode);
}


add_action("tkp/payment/admin/option", "tkp_include_admin_paypal_options", 10, 2);
function tkp_include_admin_paypal_options($payment, $settings){
    $filepath = ADMIN_PATH . "parts/payments/$payment.php";
    if( file_exists( $filepath ) ){
        global $fields;
        include $filepath;
    }
}

add_action("tkp/after/update/post", "tkp_paypal_create_products_subscription", 10, 2);
function tkp_paypal_create_products_subscription($postID, $data){
    if( isset( $data['type'] ) && $data['type'] == 'plan' ){
        include HELPER_PATH . "paypalSubscription.php";
        $paypal = new AST\Helper\paypalSubscription();
        $paypal->updatePlans($postID);
    }
}