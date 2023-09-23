<div class="card bg-white mt-3">
    <div class="card-header">Additional Settings</div>
    <div class="card-body">
        <?php
            $fields->set(array(
                "type" => "input",
                "atts" => array(
                    "type" => "number",
                    "name" => "meta[suggestion_count]",
                    "class" => "form-control"
                ),
                "value" => $dnsCount,
                "title" => "Total Suggestion Count"
            ))->render();

            $fields->set(array(
                "type" => "input",
                "atts" => array(
                    "type" => "url",
                    "name" => "meta[buy_now_link]",
                    "class" => "form-control"
                ),
                "value" => $buynowlink,
                "title" => "Buy Now Link",
                "after_input" => "You can add referal links. You can also add shortcode such as <strong>{{domain}}</strong>, <strong>{{url}}</strong>."
            ))->render();
        ?>
    </div>
</div>