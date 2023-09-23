<?php
/**
 * Get settings data
 * 
 */
global $fields;
?>
<div class="col-12">
    <div class="card bg-white">
        <div class="settings_form w-100">
            <div class="settings_title">Options</div>

            <div class="settings_content p-3">
                <div class="row">
                    <div class="col-12 mb-2">
                        <strong>Tool Route</strong>
                    </div>
                    <?php 
                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "tool_route"
                            ),
                            "value" => TOOL_ROUTE,
                            "title" => "Single Tool Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/TOOL_SLUG/', get_site_url(), TOOL_ROUTE)
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "tool_category"
                            ),
                            "value" => ALL_TOOL_CATEGORY_ROUTE,
                            "title" => "Tool Category Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/TOOL_CATEGORY_SLUG/', get_site_url(), ALL_TOOL_CATEGORY_ROUTE)
                        ))->render();
                    ?>

                    <div class="col-12 mb-2">
                        <strong>Blog Route</strong>
                    </div>

                    <?php 
                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "all_blogs_route"
                            ),
                            "value" => ALL_BLOG_ROUTE,
                            "title" => "All Blogs Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/', get_site_url(), ALL_BLOG_ROUTE)
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "blog_category"
                            ),
                            "value" => ALL_BLOG_CATEGORY_ROUTE,
                            "title" => "Blog Category Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/BLOG_CATEGORY_SLUG/', get_site_url(), ALL_BLOG_CATEGORY_ROUTE)
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "single_blog"
                            ),
                            "value" => BLOG_ROUTE,
                            "title" => "Single Blog Route",
                            "wrapper" => '<div class="col-md-12">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/BLOG_SLUG/', get_site_url(), BLOG_ROUTE)
                        ))->render();
                    ?>

                    <div class="col-12 mb-2">
                        <strong>Page Route</strong>
                    </div>

                    <?php 
                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "page_route"
                            ),
                            "value" => PAGE_ROUTE,
                            "title" => "Single Page Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/PAGE_SLUG/', get_site_url(), PAGE_ROUTE)
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "contact_page"
                            ),
                            "value" => CONTACT_ROUTE,
                            "title" => "Contact Page Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/', get_site_url(), CONTACT_ROUTE)
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "class" => "form-control",
                                "name" => "account_page"
                            ),
                            "value" => ACCOUNT_ROUTE,
                            "title" => "Account Page Route",
                            "wrapper" => '<div class="col-md-6">%s</div>',
                            "after_input" => sprintf('<span>%s<strong>%s</strong>/*', get_site_url(), ACCOUNT_ROUTE)
                        ))->render();
                    ?>
                </div>
            </div>

            <div class="settings_footer">
                <input type="text" class="d-none" name="action" value="update_route_settings">
                <button type="button" class="btn btn-primary updateRouteSettings">Update Route Settings</button>
            </div>
        </div>
    </div>
</div>