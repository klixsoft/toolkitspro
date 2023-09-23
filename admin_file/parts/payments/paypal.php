
<div class="form-group">
    <button type="button" class="btn btn-primary clearPaypalBtn">Clear Paypal Data</button>
</div>

<?php
$fields->set(array(
    "type" => "toggle",
    "atts" => array(
        "type" => "checkbox",
        "class" => "",
        "name" => "paypal[sandbox]"
    ),
    "value" => @$settings->paypal['sandbox'],
    "title" => "Enable Sandbox"
))->render();

$fields->set(array(
    "type" => "input",
    "atts" => array(
        "type" => "text",
        "class" => "form-control",
        "name" => "paypal[clientid]"
    ),
    "value" => @$settings->paypal['clientid'],
    "title" => "Client ID"
))->render();

$fields->set(array(
    "type" => "input",
    "atts" => array(
        "type" => "text",
        "class" => "form-control",
        "name" => "paypal[secret]"
    ),
    "value" => @$settings->paypal['secret'],
    "title" => "Secret key"
))->render();