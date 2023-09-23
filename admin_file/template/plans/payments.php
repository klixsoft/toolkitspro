<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "payment_methods";
$settings = get_settings($settings_key);
$payments = get_payment_methods();
?>

<div class="col-12 pricing_plan_container">
    <div class="card bg-white">
        <div class="card-header p-0 shadow-sm">
            <nav>
                <div class="nav nav-tabs" role="tablist">
                    <?php
                        foreach($payments as $key => $payment){
                            $title = ucwords(str_replace("-", " ", $payment));
                            echo sprintf('<button class="nav-link %s" data-bs-toggle="tab" data-bs-target="#nav-%s" type="button" role="tab" aria-controls="nav-%s" aria-selected="true">%s</button>', $key == 0 ? "active" : "", $payment, $payment, $title);
                        }
                    ?>
                </div>
            </nav>
        </div>

        <div class="card-body p-0">
            <div class="settings_form w-100">
                <div class="settings_content p-3">
                    <div class="tab-content">
                        <?php
                                foreach($payments as $key => $payment){
                                    $title = ucwords(str_replace("-", " ", $payment));
                                    echo sprintf('<div class="tab-pane fade %s" id="nav-%s" role="tabpanel" aria-labelledby="nav-%s-tab">', $key == 0 ? "active show" : "", $payment, $payment);

                                    $fields->set(array(
                                        "type" => "toggle",
                                        "atts" => array(
                                            "type" => "checkbox",
                                            "class" => "",
                                            "name" => $payment . "[enable]"
                                        ),
                                        "value" => @$settings->$payment['enable'],
                                        "title" => "Enable"
                                    ))->render();

                                    do_action("tkp/payment/admin/option", $payment, $settings);

                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => $payment . "[icon]"
                                        ),
                                        "value" => @$settings->$payment['icon'],
                                        "title" => $title . " Icon"
                                    ))->render();
                                    
                                    $fields->set(array(
                                        "type" => "input",
                                        "atts" => array(
                                            "type" => "text",
                                            "class" => "form-control",
                                            "name" => $payment . "[text]"
                                        ),
                                        "value" => @$settings->$payment['text'],
                                        "title" => $title . " Text"
                                    ))->render();

                                    echo '</div>';
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer p-0">
            <div class="settings_footer">
                <button type="button" class="btn btn-primary updateSettings"
                    data-key="<?php echo $settings_key; ?>">Update Settings</button>
            </div>
        </div>
    </div>
</div>