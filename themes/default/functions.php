<?php

add_action("add_scripts", "toolkitspro_include_front_scripts", 1);
function toolkitspro_include_front_scripts(){
    /** INCLUDE CSS CODES */
    add_css_script("bootstrap", "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css", false);
    $version = filemtime( get_theme_path() . "assets/css/style.css" );
    add_css_script("main", sprintf("%s?ver=%s", get_theme_url() . "assets/css/style.css", $version), false);

    if( is_dark_theme() ){
        $version = filemtime( get_theme_path() . "assets/css/style-dark.css" );
        add_css_script("darktheme", sprintf("%s?ver=%s", get_theme_url() . "assets/css/style-dark.css", $version), false);
    }

    /** INCLUDE JAVASCRIPT CODES */
    add_js_script("lozad", "https://cdn.jsdelivr.net/npm/lozad");
    add_code_after_script("lozad", 'lozad(".lozad", {
        load: function(el) {
            el.style.backgroundImage = `url(${el.dataset.src})`;
            el.classList.add("loaded");
            el.removeAttribute("data-src");
        }
    }).observe();');
    add_js_script("jquery", "https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js");

    $version = filemtime( get_theme_path() . "assets/js/main.js" );
    add_js_script("main", sprintf("%s?ver=%s", get_theme_url() . "assets/js/main.js", $version), true, array(
        "defer" => "",
        "async" => ""
    ));

    if( AST\View::isCustomPage("checkout") ){
        $settings = get_payment_method_setting("paypal");
        if( isset( $settings['clientid'] ) && !empty($settings['clientid']) ){
            add_js_script("paypal-sdk", sprintf("https://www.paypal.com/sdk/js?client-id=%s&components=buttons&vault=true&intent=subscription", $settings['clientid']));

            $version = filemtime( get_theme_path() . "assets/js/checkout/paypal.js" );
            add_js_script("paypal-checkout", sprintf("%s?ver=%s", get_theme_url() . "assets/js/checkout/paypal.js", $version), true, array(
                "defer" => "",
                "async" => ""
            ));
        }
    }
}

/**
 * Include tool beadcrum dynamically
 */
add_action("ast/tool/html/beadcrum", function($tooldata){
    include get_theme_path() . "parts/tool/beadcrum.php";
});

add_action("ast/tool/html/content", function($tooldata, $toolreport, $extraparams = false, $includeSidebar = true){
    if( $includeSidebar ){
        include get_theme_path() . "parts/tool/with-sidebar.php";
    }else{
        include get_theme_path() . "parts/tool/without-sidebar.php";
    }

    do_action("tkp/after/tool/content", $tooldata);
}, 10, 4);

add_action("ast/post/sidebar", function($tooldata, $posttype){
    include get_theme_path() . "parts/tool/sidebar.php";
}, 10, 2);

add_action("ast/tool/after/content", "include_related_tools_after_toolcontent", 10, 4);
function include_related_tools_after_toolcontent( $tool ){
    if( $tool->type == 'tool' ){
        $toolcat = get_meta("tool", $tool->id, "category");
        if( !empty( $toolcat ) && count( $toolcat ) > 0 ){
            $tools = get_tools_by_category($toolcat[0], 8);
            if( !empty( $tools ) && count( $tools ) > 1 ){
                $activeTool = $tool->id;
                include get_theme_path() . "parts/tool/relevant.php";
            }
        }
    }
}

add_action("ajax/req/search_tool", "tkp_search_tool");
add_action("ajax/req/nologin/search_tool", "tkp_search_tool");
function tkp_search_tool(){
    $output = array(
        "success" => false,
        "message" => "Unable to search!!!"
    );

    if( isset($_POST['query']) ){
        $query = trim($_POST['query']);

        global $db;

        if( strlen($query) <= 1 ){
            $sqlQuery = "SELECT * from posts where type='tool' AND status='active' AND (title LIKE CONCAT('%', ?, '%')) order by views desc LIMIT 20";
            $tools = $db->rawQuery($sqlQuery, Array ($query));
        }else{
            $sqlQuery = "SELECT *,
                CASE
                    WHEN title = ? THEN 3
                    WHEN title LIKE CONCAT(?, '%') THEN 2
                    WHEN title LIKE CONCAT('%', ?, '%') THEN 1
                    ELSE 0
                END AS match_priority
            FROM posts
            WHERE type='tool' AND status='active' AND title LIKE CONCAT('%', ?, '%')
            ORDER BY match_priority DESC LIMIT 20";
            $tools = $db->rawQuery($sqlQuery, Array ($query, $query, $query, $query));
        }
        $lastQuery = $db->getLastQuery();

        $html = "";
        foreach($tools as $tool){
            $html .= get_tool_card_html($tool, false);
        }

        $output = array(
            "success" => true,
            "message" => empty( $html ) ? bs_alert("No tool found according to your query!!!", "danger w-100") : $html
        );
    }
    
    ast_send_json($output);
}

add_action("ajax/req/contact_form", "handle_contact_form_request");
add_action("ajax/req/nologin/contact_form", "handle_contact_form_request");
function handle_contact_form_request(){
    if( 
        !empty( @$_POST['fullname'] )
        && !empty( @$_POST['email'] )
        && !empty( @$_POST['message'] )
    ){
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $message = trim($_POST['message']);
        $subject = trim($_POST['subject']);

        $title = "Someone try to contact you";
        $messageHTML = sprintf('<table>
            <tr>
                <td>Name:</td>
                <td>%s</td>
            </tr>

            <tr>
                <td>Email:</td>
                <td>%s</td>
            </tr>

            <tr>
                <td>Subject:</td>
                <td>%s</td>
            </tr>

            <tr>
                <td>Message:</td>
                <td>%s</td>
            </tr>
        </table>', $fullname, $email, $subject, $message);

        $template_message = get_mail_template(array(
            "name" => $fullname,
            "title" => $title,
            "include_title" => true,
            "message" => $messageHTML,
            "after_message" => ""
        ));

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            sprintf('From: %s <%s>', $fullname, $email)
        );

        $toEmail = get_settings("adminemail");
        if( ! empty( $toEmail ) ){
            if( ast_mail($toEmail, $title, $template_message, $headers) ){
                return array(
                    "type" => "success",
                    "message" => "Thanks for contacting us. We will reach you soon!!!"
                );
            }
        }

        ast_send_json(array(
            "type" => "error",
            "message" => "Unable to send your message!!!"
        ));
    }
    
    ast_send_json(array(
        "type" => "error",
        "message" => "All Field are required!!!"
    ));
}

add_action("tkp/checkout/overview", "include_order_overview", 10, 2);
function include_order_overview($order, $ordertype){
    $price = get_meta("plan", $order->id, "{$ordertype}price", "0");
    include get_theme_path() . "parts/checkout/overview.php";
}

add_action("tkp/checkout/payments", "include_payment_overview", 10, 3);
function include_payment_overview($defaultpayment, $order, $orderType){
    $settings_key = "payment_methods";
    $settings = (array) get_settings($settings_key);
    $payments = get_payment_methods_front();
    include get_theme_path() . "parts/checkout/payment.php";
}

add_filter("tkp/payment/options/paypal", "thp_checkout_include_paypal_options", 10, 3);
function thp_checkout_include_paypal_options($html, $order, $orderType){
    $planID = get_meta("plan", $order->id, "paypal_{$orderType}_plan_id");
    ob_start();
    include get_theme_path() . "parts/checkout/options/paypal.php";
    return ob_get_clean();
}

add_filter("tkp/payment/options/stripe", "thp_checkout_include_stripe_options", 10, 3);
function thp_checkout_include_stripe_options($html, $order, $orderType){
    ob_start();
    include get_theme_path() . "parts/checkout/options/stripe.php";
    return ob_get_clean();
}

add_filter("tkp/payment/options/bank-transfer", "thp_checkout_include_banktransfer_options", 10, 3);
function thp_checkout_include_banktransfer_options($html, $order, $orderType){
    ob_start();
    include get_theme_path() . "parts/checkout/options/bank-transfer.php";
    return ob_get_clean();
}