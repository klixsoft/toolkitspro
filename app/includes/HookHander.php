<?php
use AST\Cookie;

add_action("ast_front_header", "include_root_styles");
add_action("admin_header", "include_root_styles");
add_action("print_root_css_code", "include_root_styles");
function include_root_styles(){
    echo '<style>';
    echo ':root{';
    echo '--fontfamily:Roboto, helvetica neue, Helvetica, Arial, sans-serif;';

    $colors = get_color_pallate();
    $maskimage = get_site_url("admin_file/assets/img/mask.webp");
    echo sprintf('--primary:%s;', $colors['primary']);
    echo sprintf('--primaryrgb:%s;', rgb_implode($colors['primary']));
    echo sprintf('--background:%s;', $colors['background']);
    echo sprintf('--backgroundrgb:%s;', rgb_implode($colors['background']));
    echo sprintf('--text-color:%s;', $colors['text-color']);
    echo sprintf('--card-back:%s;', $colors['card-back']);
    echo sprintf('--textureurl:url(%s);', $maskimage);

    echo '}';
    echo '</style>';
}

add_action("ast/front/after/body", "include_svg_gradient_color");
add_action("ast/admin/after/body", "include_svg_gradient_color");
function include_svg_gradient_color(){
    global $colors;
    $rgb = hex_to_rgba($colors["icon-first-color"]);
    $rgblast = hex_to_rgba($colors["icon-last-color"]);
    echo '<svg style="position:absolute;width:0;height:0;left:-100px;">
        <defs>
            <linearGradient id="gradientColor" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:'.$rgb.';stop-opacity:1" />
                <stop offset="100%" style="stop-color:'.$rgblast.';stop-opacity:1" />
            </linearGradient>
        </defs>
    </svg>';
}

add_action("ast_front_footer", function(){
    require_once APP_PATH . "templates/loading-overlay.php";
    require_once APP_PATH . "templates/info-modal.php";
});

add_filter("ast/shortcode/content", function($content, $shortcode, $atts){
    extract($atts);
    if( $shortcode == 'how_to_convert' ){
        ob_start();
        include APP_PATH . "templates/shortcodes/how_to_convert.php";
        $content = ob_get_contents();
        ob_get_clean();
    }

    return $content;
}, 10, 3);

add_filter("ast/post/description", function($content){
    
    $pattern = '/\[(\w+)\s+(.*?)\]/';
    $content = preg_replace_callback($pattern, function($matches) {
        $shortcode = $matches[1];
    
        $atts = array();
        $attsPattern = '/(\w+)="([^"]+)"/';
        preg_match_all($attsPattern, $matches[2], $attsMatches, PREG_SET_ORDER);
        
        foreach ($attsMatches as $attsMatch) {
            $atts[$attsMatch[1]] = $attsMatch[2];
        }
    
        return apply_filters("ast/shortcode/content", "", strtolower($shortcode), $atts);
    }, $content);

    return $content;
}, 10, 1);

add_filter( 'ast_mail_content_type', function() {
	return 'text/html';
});

function getLastToolUpdate($feed){
    global $db;
    $db->where("type", $feed);
    $db->orderBy("date", "desc");
    $result = $db->ObjectBuilder()->get("posts", 1);
    if( ! empty( $result ) ){
        return strtotime($result[0]->date);
    }

    return time();
}

add_action("tkp/feed/content", function(){
    header('Content-Type: application/rss+xml; charset=UTF-8');
    $feed = "tool";

    $output = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $output = '<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">' . PHP_EOL;
    $output .= '    <channel>' . PHP_EOL;

    $settings = get_settings("basic");
    $output .= sprintf('        <title>%s</title>', $settings->name) . PHP_EOL;
    $output .= sprintf('        <link>%s</link>', get_site_url()) . PHP_EOL;
    $output .= sprintf('        <description>%s</description>', htmlspecialchars($settings->description)) . PHP_EOL;
    $output .= sprintf('        <atom:link rel="self" xmlns:atom="http://www.w3.org/2005/Atom" href="%s" type="application/rss+xml" />', get_site_url("feed/")) . PHP_EOL;
    $output .= '        <language>en</language>' . PHP_EOL;
    $output .= sprintf('        <lastBuildDate>%s</lastBuildDate>', date('D, d M Y H:i:s +0000', getLastToolUpdate($feed))) . PHP_EOL;
    
    $posts = get_lastupdate_post_type($feed);
    foreach($posts as $post){
        $url = $feed == 'tool' ? get_tool_url("slug", $post->slug) : get_post_url("slug", $post->slug);
        
        $category = '';
        $categoryIDs = get_post_category($feed, $post->id);
        if( !empty( $categoryIDs ) ){
            $category = get_category_by("id", $categoryIDs[0]);
            if( ! empty( $category ) ){
                $category = sprintf('<category domain="%s">%s</category>', get_category_url("slug", $category['slug'], $feed), $category['title']);
            }
        }

        // $description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $post->description);
        $description = preg_replace('/<(\w+)\s+[^>]*>/', '', $post->description);
        $description = htmlspecialchars($description);
        $output .= PHP_EOL . sprintf('        <item>
            <title>%s</title>
            <link>%s</link>
            <description>%s</description>
            %s
            <guid>%s</guid>
            <pubDate>%s</pubDate>
        </item>', htmlspecialchars($post->title), $url, $description, $category, $url, date('D, d M Y H:i:s +0000', strtotime($post->date))) . PHP_EOL;
    }

    $output .= '</channel>' . PHP_EOL;
    $output .= '</rss>';
    echo apply_filters("tkp/rss/feed/content", $output);
    die();
});

function addDefsElementToSVG($svgCode, $rgb, $rgblast)
{
    $defines = '<defs><linearGradient id="gradientColor" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:'.$rgb.';stop-opacity:1" /><stop offset="100%" style="stop-color:'.$rgblast.';stop-opacity:1" /></linearGradient></defs>';
    $svgCode = preg_replace('/(<svg[^>]*>)/', '$1' . $defines, $svgCode);
    $svgCode = str_replace('"tool_gradient_color"', '"tool_gradient_color" fill="url(#gradientColor)"', $svgCode);
    return trim($svgCode);
}

add_action("tkp/svg/icon", function($toolslug, $svgof){
    global $colors;
    $rgb = hex_to_rgba($colors["icon-first-color"]);
    $rgblast = hex_to_rgba($colors["icon-last-color"]);

    $svgIcon = TOOLS_PATH . $toolslug . "/icon.svg";
    if( file_exists( $svgIcon ) ){
        header('Content-Type: image/svg+xml');
        $content = file_get_contents($svgIcon);
        $content = addDefsElementToSVG($content, $rgb, $rgblast);
        echo $content;
    }
}, 10, 2);

add_action("ast_front_footer", "toolkitspro_implement_analytics_code");
function toolkitspro_implement_analytics_code(){
    $settings = get_settings("basic");
    echo @$settings->ganalytics;
}

function toolkitspro_implement_replace_icon_color( $colors, $postfix="" ){
    $rgb = hex_to_rgba($colors["icon-first-color"]);
    $rgblast = hex_to_rgba($colors["icon-last-color"]);

    $plugins = glob(TOOLS_PATH . "*");
    foreach($plugins as $plugin){
        $svgIcon = $plugin . "/icon.svg";
        if( is_dir($plugin) && file_exists( $svgIcon ) ){
            $outputFile = str_replace("icon.svg", "cicon$postfix.svg", $svgIcon);
            $content = file_get_contents($svgIcon);
            $content = addDefsElementToSVG($content, $rgb, $rgblast);
            file_put_contents($outputFile, $content);
        }
    }
}

add_action("tkp/update/setttings", "toolkitspro_update_icons_with_colors");
function toolkitspro_update_icons_with_colors($settingskey){
    if( $settingskey == 'colors' ){
        toolkitspro_implement_replace_icon_color($_POST['settings']['light']);
        toolkitspro_implement_replace_icon_color($_POST['settings']['dark'], "-dark");

        /** CHANGE LOGO COLOR */
        $sitelogo = ADMIN_PATH . "assets/img/clogo.svg";
        $outputFile = str_replace("clogo.svg", "logo.svg", $sitelogo);
        $content = file_get_contents($sitelogo);
        $content = str_replace('id="tool_primary_color"', sprintf('fill="%s"', $_POST['settings']['light']['primary']), $content);
        file_put_contents($outputFile, $content);
    }
}

add_action("ast_front_header", "include_front_header_scripts");
function include_front_header_scripts(){
    global $minification;
    $minification->include_front_scripts("header");
}

add_action("ast_front_footer", "include_front_footer_scripts", 1);
function include_front_footer_scripts(){
    global $minification;
    $minification->include_front_scripts("footer");
}

add_action("tkp/callback/paypal-webhook", "tkp_handle_paypal_webhook");
function tkp_handle_paypal_webhook(){
    $webhookData = file_get_contents('php://input');
    $eventData = json_decode($webhookData);
    
    if( @$eventData->resource_type == 'subscription' ){
        $subId = $eventData->resource->id;
        global $db;
        $db->where("orderid=? AND source=?", array($subId, "paypal"));
        $order = $db->objectBuilder()->getOne("orders");
        if( ! empty( $order ) ){
            $status = strtolower($eventData->resource->status);
            $status = str_replace("approval_", "", $status);
            
            $db->update("orders", array(
                "status" => $status
            ), array(
                "id" => $order->id
            ));
        }
    }   
}

add_filter("ast/front/footer/config", "include_user_plan_data");
function include_user_plan_data($data){
    $plan = get_active_user_plan();
    
    $removeData = array("paypal_monthly_plan_id", "paypal_monthly_plan_data", "paypal_yearly_plan_id", "paypal_yearly_plan_data", "monthlyprice", "yearlyprice", "featured_image");
    foreach($removeData as $key){
        if( isset($plan->meta->$key) ){
            unset($plan->meta->$key);
        }
    }
    unset($plan->date);
    unset($plan->modified);
    unset($plan->id);
    unset($plan->author);

    $data['user'] = array(
        "plan" => @$plan->plan,
        "subscribed" => @$plan->subscribed
    );
    return $data;
}

add_action("ajax/req/validate_captcha", "tkp_validate_captcha");
function tkp_validate_captcha(){
    $valdation = (object) apply_filters("ast/before/ajax/req", array(
        "success" => true,
        "message" => "Recaptcha Validate Successfully"
    ));

    ast_send_json($valdation);
}