<?php global $fields; ?>

<div class="col-md-12">
    <form action="<?php echo get_full_url(); ?>" method="post" class="post_submit_form">
        <div class="row">
            <div class="col-md-9">
                <div class="card bg-white p-3">
                    <div class="has_messages"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Plan Name</label>
                                <input type="text" value="<?php echo $pagedata->title; ?>" required class="form-control" name="post_title" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" name="post_des"><?php echo $pagedata->description; ?></textarea>
                            </div>
                        </div>

                        <?php
                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[wordcount]"
                                ),
                                "value" => $metadata->wordcount,
                                "title" => "Word Count",
                                "wrapper" => '<div class="col-md-6">%s</div>',
                                "after_input" => "Maximum number of words allowed in a text, such as in a article rewrite or plagiarism checker."
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[filesize]"
                                ),
                                "value" => $metadata->filesize,
                                "title" => "File Size",
                                "wrapper" => '<div class="col-md-6">%s</div>',
                                "after_input" => "Maximum size of a file that can be uploaded, size must be in megabytes."
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[imagenum]"
                                ),
                                "value" => $metadata->imagenum,
                                "title" => "No of Image",
                                "wrapper" => '<div class="col-md-6">%s</div>',
                                "after_input" => "Maximum number of images that can be uploaded on supported tools."
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[urlnums]"
                                ),
                                "value" => $metadata->urlnums,
                                "title" => "Number of URLs",
                                "wrapper" => '<div class="col-md-6">%s</div>',
                                "after_input" => "Maximum number of domains that can be processed in single request."
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[dailyusage]"
                                ),
                                "value" => $metadata->dailyusage,
                                "title" => "Daily Usage",
                                "wrapper" => '<div class="col-md-12">%s</div>',
                                "after_input" => "Number of requests that a user can perform within a 24-hour period."
                            ))->render();
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-white p-3">
                    <?php
                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "type" => "text",
                                "class" => "form-control",
                                "name" => "meta[monthlyprice]",
                                "required" => "required"
                            ),
                            "value" => $metadata->monthlyprice,
                            "title" => "Monthly Price",
                            "wrapper" => '<div class="col-md-12">%s</div>'
                        ))->render();

                        $fields->set(array(
                            "type" => "input",
                            "atts" => array(
                                "type" => "text",
                                "class" => "form-control",
                                "name" => "meta[yearlyprice]",
                                "required" => "required"
                            ),
                            "value" => $metadata->yearlyprice,
                            "title" => "Yearly Price",
                            "wrapper" => '<div class="col-md-12">%s</div>'
                        ))->render();

                        $fields->set(array(
                            "type" => "toggle",
                            "atts" => array(
                                "type" => "checkbox",
                                "class" => "",
                                "name" => "meta[allowapi]"
                            ),
                            "value" => $metadata->allowapi,
                            "title" => "Allow API",
                            "wrapper" => '<div class="col-md-12">%s</div>'
                        ))->render();

                        $fields->set(array(
                            "type" => "toggle",
                            "atts" => array(
                                "type" => "checkbox",
                                "class" => "",
                                "name" => "meta[noads]"
                            ),
                            "value" => $metadata->noads,
                            "title" => "No Advertisement",
                            "wrapper" => '<div class="col-md-12">%s</div>'
                        ))->render();
                    ?>

                    <input type="text" name="post_id" style="display:none;" value="<?php echo $pagedata->id; ?>">
                    <input type="text" name="action" value="publish_update_post" style="display:none;">
                    <input type="text" name="post_type" value="plan" style="display:none;">
                    <button class="btn btn-primary btn-block publishbtn" type="submit">Publish</button>
                </div>

                <?php if( is_payment_method_active("paypal") && $pagedata->extra == 'plan' ): ?>
                <div class="card bg-white">
                    <div class="card-header">Paypal</div>
                    <div class="card-body p-2">
                        <?php
                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[paypal_yearly_plan_id]",
                                    "required" => "required"
                                ),
                                "value" => @$metadata->paypal_yearly_plan_id,
                                "title" => "Monthly Plan ID",
                                "wrapper" => '<div class="col-md-12">%s</div>'
                            ))->render();

                            $fields->set(array(
                                "type" => "input",
                                "atts" => array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "name" => "meta[paypal_monthly_plan_id]",
                                    "required" => "required"
                                ),
                                "value" => @$metadata->paypal_yearly_plan_id,
                                "title" => "Yearly Plan ID",
                                "wrapper" => '<div class="col-md-12">%s</div>'
                            ))->render();
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>