<style>
.seodetailsinfo code{
    background: #e83e8c;
    color: #fff;
    padding: 2px 6px;
    border-radius: 3px;
    margin-right:10px;
} 

.seodetailsinfo li{
    margin-bottom: 5px;
    list-style: square;
}

.add_category_form .card{
    box-shadow:none;
}

.add_category_form .card-body,
.add_category_form .card-header{
    padding-left:0;
    padding-right:0;
    padding-bottom:0;
}

.add_category_form .card-header{
    font-weight:bold;
}
</style>

<div class="card bg-white">
    <div class="card-header">SEO Details</div>
    <div class="card-body">

        <!-- <div class="alert alert-info seodetailsinfo">
            You can use following shortcodes
            <ul class="pb-0 pl-3 mb-0 mt-2">
                <li><code>%sitename%</code>Title of the site</li>
                <li><code>%sitedes%</code>Description of the site</li>
                <li><code>%sep%</code>Separator</li>
                <li><code>%seotitle%</code>Your current page title.</li>
                <li><code>%seodes%</code>Convert your description to the meta description.</li>
                <li><code>%seokeywords%</code>Convert your meta description to the meta keywords.</li>
                <li><code>%currentdate%</code>Current date in format (<?php echo date("Y-m-d"); ?>)</li>
                <li><code>%currentyear%</code>Current Server year</li>
                <li><code>%currentmonth%</code>Current Server month</li>
                <li><code>%currenttime%</code>Current Server time (<?php echo date("h:i A"); ?>)</li>
            </ul>
        </div> -->

        <div class="row">
            <?php
                $fields->set(array(
                    "type" => "input",
                    "atts" => array(
                        "type" => "text",
                        "class" => "form-control",
                        "name" => "meta[seo_title]"
                    ),
                    "title" => "Title",
                    "value" => $seo_title,
                    "wrapper" => '<div class="col-sm-8">%s</div>'
                ))->render();

                $fields->set(array(
                    "type" => "toggle",
                    "atts" => array(
                        "class" => "",
                        "name" => "meta[robotindex]"
                    ),
                    "title" => "Content Index",
                    "value" => $robotindex,
                    "wrapper" => '<div class="offset-sm-1 col-sm-2">%s</div>'
                ))->render();

                $fields->set(array(
                    "type" => "textarea",
                    "atts" => array(
                        "class" => "form-control",
                        "name" => "meta[seo_des]",
                        "rows" => 4
                    ),
                    "title" => "Description",
                    "value" => $seo_des,
                    "wrapper" => '<div class="col-sm-12">%s</div>'
                ))->render();

                $fields->set(array(
                    "type" => "textarea",
                    "atts" => array(
                        "class" => "form-control",
                        "name" => "meta[seo_keywords]",
                        "rows" => 4
                    ),
                    "title" => "Keywords",
                    "value" => $seo_keywords,
                    "wrapper" => '<div class="col-sm-12">%s</div>'
                ))->render();
            ?>
        </div>
    </div>
</div>