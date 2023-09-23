<?php

add_filter("ast/admin/apikeys", function($fields){
    if( isset( $fields['moz_accessid'] ) ){
        $fields['moz_accessid']['access'][] = "page-authority-checker";
        $fields['moz_secretkey']['access'][] = "page-authority-checker";
    }else{
        $fields['moz_accessid'] = array(
            "type" => "input",
            "atts" => array(
                "type" => "text",
                "class" => "form-control tagin",
                "placeholder" => "Access ID"
            ),
            "title" => "MOZ Access ID",
            "wrapper" => '<div class="col-md-12">%s</div>',
            "access" => array("page-authority-checker")
        );
        $fields['moz_secretkey'] = array(
            "type" => "input",
            "atts" => array(
                "type" => "text",
                "class" => "form-control tagin",
                "placeholder" => "Secret Key"
            ),
            "title" => "MOZ Secret Key",
            "wrapper" => '<div class="col-md-12">%s</div>',
            "access" => array("page-authority-checker")
        );
    }
    return $fields;
});