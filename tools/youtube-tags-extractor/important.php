<?php

add_filter("ast/admin/apikeys", function($fields){
    $fields['youtubeapi'] = array(
        "type" => "input",
        "atts" => array(
            "type" => "text",
            "class" => "form-control",
            "placeholder" => "API Keys"
        ),
        "title" => "Youtube API Key",
        "wrapper" => '<div class="col-md-12">%s</div>'
    );
    return $fields;
});