<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "mail";
$settings = get_settings($settings_key);
?>

<div class="col-12">
    <div class="card bg-white settings_form mail_settings_form">
        <div class="settings_form w-100">
            <div class="settings_title">Options</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12">
                        <?php
                            $fields->set(array(
                                "type" => "select",
                                "options" => array(
                                    "default" => "PHP Mail Function",
                                    "smtp" => "SMPT"
                                ),
                                "atts" => array(
                                    "class" => "form-control",
                                    "name" => "protocol"
                                ),
                                "value" => @$settings->protocol,
                                "title" => "Select your Mail Protocol:"
                            ))->render();
                        ?>
                    </div>

                    <div class="col-12">
                        <div class="smtp_information">
                            <h5>SMTP Information</h5>

                            <div class="row">
                                <?php
                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => "smtp[host]"
                                        ),
                                        "value" => @$settings->smtp->host,
                                        "title" => "SMTP Host",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();

                                    $fields->set(array(
                                        "type" => "select",
                                        "options" => array(
                                            "yes" => "Yes",
                                            "no" => "No"
                                        ),
                                        "atts" => array(
                                            "class" => "form-control",
                                            "name" => "smtp[auth]"
                                        ),
                                        "value" => @$settings->smtp->auth,
                                        "title" => "Auth",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();

                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => "smtp[port]"
                                        ),
                                        "value" => @$settings->smtp->host || 587,
                                        "title" => "SMTP PORT",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();

                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => "smtp[username]"
                                        ),
                                        "value" => @$settings->smtp->username,
                                        "title" => "SMTP Username",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();

                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => "smtp[password]"
                                        ),
                                        "value" => @$settings->smtp->password,
                                        "title" => "SMTP Password",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();

                                    $fields->set(array(
                                        "type" => "select",
                                        "options" => array(
                                            "tls" => "TLS",
                                            "ssl" => "SSL"
                                        ),
                                        "atts" => array(
                                            "class" => "form-control",
                                            "name" => "smtp[ssl]"
                                        ),
                                        "value" => @$settings->smtp->auth,
                                        "title" => "SMTP Secure Socket",
                                        "wrapper" => '<div class="col-md-12">%s</div>'
                                    ))->render();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings_footer">
                <button type="button" class="btn btn-primary updateSettings"
                    data-key="<?php echo $settings_key; ?>">Update Settings</button>
            </div>
        </div>
    </div>
</div>