<?php
/**
 * Get settings data
 * 
 */
global $fields;
$settings_key = "basic";
$settings = get_settings($settings_key);
?>

<div class="col-md-8">
    <div class="card bg-white">
        <div class="settings_form w-100">
            <div class="settings_title">Options</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12">
                        <?php                            
                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "name",
                                    "required" => "",
                                    "data-alert" => "Site Name is Required!!!"
                                ),
                                "value" => @$settings->name,
                                "title" => "Site Name"
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "title",
                                    "required" => "",
                                    "data-alert" => "Site Title is Required!!!"
                                ),
                                "value" => @$settings->title,
                                "title" => "Site Title"
                            ))->render();

                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "class" => "form-control",
                                    "name" => "description",
                                    "required" => "",
                                    "data-alert" => "Site Description is Required!!!",
                                    "rows" => 4
                                ),
                                "value" => @$settings->description,
                                "title" => "Site Description"
                            ))->render();

                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "class" => "form-control",
                                    "name" => "keywords",
                                    "rows" => 4
                                ),
                                "value" => @$settings->keywords,
                                "title" => "Site Keywords"
                            ))->render();
                            

                            echo '<div class="row"><div class="col-md-4">';
                            echo get_image_picker_container(@$settings->favicon_image, "favicon_image", "Favicon Image");
                            echo '</div><div class="col-md-4">';
                            echo get_image_picker_container(@$settings->branding_logo, "branding_logo", "Branding Logo Image");
                            echo '</div><div class="col-md-4">';
                            echo get_image_picker_container(@$settings->featured_image, "featured_image", "Featured Image");
                            echo '</div><div class="col-md-4">';
                            echo get_image_picker_container(@$settings->website_logo, "website_logo", "Logo Light Image");
                            echo '</div><div class="col-md-4">';
                            echo get_image_picker_container(@$settings->website_dark_logo, "website_logo", "Logo Dark Image");
                            echo '</div></div>';

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "separator",
                                    "required" => "",
                                    "data-alert" => "Separator is Required!!!"
                                ),
                                "value" => @$settings->separator,
                                "title" => "Separator"
                            ))->render();

                            $fields->set(array(
                                "type" => "textarea",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "copyright",
                                    "rows" => 2
                                ),
                                "after_input" => "Basic HTML is supported!!!",
                                "value" => @$settings->copyright,
                                "title" => "Copyright"
                            ))->render();


                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "ganalytics"
                                ),
                                "after_input" => "Only, Google Analytics (V4) is supported!!!",
                                "value" => @$settings->ganalytics,
                                "title" => "Google Analytics Code"
                            ))->render();
                        ?>
                    </div>

                    <?php
                        /**
                         * Other basic settings
                         * 
                         * @since 1.0
                         */
                        do_action("ast/admin/settings/basic", $settings);
                    ?>
                </div>
            </div>

            <div class="settings_footer">
                <button type="button" class="btn btn-primary updateSettings"
                    data-key="<?php echo $settings_key; ?>">Update Settings</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card bg-white">
        <div class="settings_form w-100">
            <div class="settings_title">Site Settings</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="more_settings row">
                            <?php
                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "disabled" => ""
                                    ),
                                    "value" => \AST\Options::get("siteurl"),
                                    "title" => "Site Address",
                                    "wrapper" => '<div class="col-12">%s</div>'
                                ))->render();
                            ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="more_settings row">
                            <?php
                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "disabled" => ""
                                    ),
                                    "value" => \AST\Options::get("adminemail"),
                                    "title" => "Admin Email",
                                    "wrapper" => '<div class="col-12">%s</div>'
                                ))->render();
                            ?>
                        </div>
                    </div>

                    <?php
                        /**
                         * Other basic settings
                         * 
                         * @since 1.0
                         */
                        do_action("ast/admin/settings/basic/right", $settings);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white mt-4">
        <div class="settings_form w-100">
            <div class="settings_title">Social Profiles</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12">
                    <?php
                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "facebook"
                                    ),
                                    "value" => @$settings->facebook,
                                    "title" => "Facebook"
                                ))->render();

                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "twitter"
                                    ),
                                    "value" => @$settings->twitter,
                                    "title" => "Twitter"
                                ))->render();

                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "instagram"
                                    ),
                                    "value" => @$settings->instagram,
                                    "title" => "Instagram"
                                ))->render();

                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "pinterest"
                                    ),
                                    "value" => @$settings->pinterest,
                                    "title" => "Pinterest"
                                ))->render();

                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "github"
                                    ),
                                    "value" => @$settings->github,
                                    "title" => "Github"
                                ))->render();

                                $fields->set(array(
                                    "type" => "input",
                                    "atts" => array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "youtube"
                                    ),
                                    "value" => @$settings->youtube,
                                    "title" => "Youtube"
                                ))->render();
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>