<?php
$fields->set(array(
    "type" => "toggle",
    "atts" => array(
        "type" => "checkbox",
        "class" => "",
        "name" => "stripe[sandbox]"
    ),
    "value" => @$settings->stripe['sandbox'],
    "title" => "Enable Sandbox"
))->render();

$fields->set(array(
    "type" => "input",
    "atts" => array(
        "type" => "text",
        "class" => "form-control",
        "name" => "stripe[api]"
    ),
    "value" => @$settings->stripe['api'],
    "title" => "API Key"
))->render();

$fields->set(array(
    "type" => "input",
    "atts" => array(
        "type" => "text",
        "class" => "form-control",
        "name" => "stripe[publishable]"
    ),
    "value" => @$settings->stripe['publishable'],
    "title" => "Publishable Key"
))->render();