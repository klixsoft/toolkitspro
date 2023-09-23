<?php
$accessKey = "bank-transfer";
$fields->set(array(
    "type" => "textarea",
    "atts" => array(
        "rows" => "4",
        "class" => "form-control",
        "name" => $accessKey . "[bankinfo]"
    ),
    "value" => @$settings->$accessKey['bankinfo'],
    "title" => "Bank Information"
))->render();
?>