<?php

use AST\View;
use AST\Plugin\SEO\MetaInfo;


add_filter("ast/meta/info", function($metainfo, $type, $data){
    if( ! has_system_installed() ) return false;

    require_once PLUGINS_PATH . "seo/MetaInfo.php";
    $metaInfoObj = new MetaInfo();
    
    if( $type == "tool" || $type == "post" || $type == "page" || $type == "article" ){
        $metainfo = $metaInfoObj->post($type, $data)->generate();
    }else if( $type == "front" ){
        $metainfo = $metaInfoObj->front()->generate();
    }else if( $type == "category" ){
        $metainfo = $metaInfoObj->category($data)->generate();
    }else if( $type == "custom" ){
        $metainfo = $metaInfoObj->custom($data)->generate();
    }

    return $metainfo;
}, 1, 3);

add_action("ast/post/additional/settings", "render_seo_settings_for_html", 100, 2);
add_action("ast/page/additional/settings", "render_seo_settings_for_html", 100, 2);
add_action("ast/tool/additional/settings", "render_seo_settings_for_html", 100, 2);
add_action("ast/category/additional/settings", "render_seo_settings_for_html", 100, 2);
function render_seo_settings_for_html( $tooldata, $type="tool" ){
    $seo_title = get_meta($type, $tooldata->id, "seo_title", "%seotitle% %sep% %sitename%");
    $seo_des = get_meta($type, $tooldata->id, "seo_des", "%seodes%");
    $seo_keywords = get_meta($type, $tooldata->id, "seo_keywords", "%seokeywords%");
    $robotindex = get_meta($type, $tooldata->id, "robotindex", true);

    global $fields;
    include ASTROOTPATH . "plugins/seo/template.php";
}