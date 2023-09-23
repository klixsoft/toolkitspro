<?php

use AST\Download;
use AST\View;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

$router->group(['before' => 'checkMantenance'], function(RouteCollector $router){

    $router->group(['before' => 'increateViews'], function(RouteCollector $router){
        $router->group(["prefix" => parse_route_constants("account"), 'before' => 'auth'], function(RouteCollector $router){
            $router->get("/", function(){
                $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                    "title" => "Account - %sitename%",
                    "description" => "Manage your account with subscription plan.",
                    "link" => get_account_url(),
                    "index" => false
                ));

                return View::render("profile", array(
                    "accountkey" => "account",
                    "metainfo" => $metainfo
                ));
            });

            $router->get("{accountkey}/", function($accountkey){
                $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                    "title" => strtoupper($accountkey) . " - Account - %sitename%",
                    "description" => "Manage your account with subscription plan.",
                    "link" => get_account_url($accountkey . "/"),
                    "index" => false
                ));
                return View::render("profile", array(
                    "accountkey" => $accountkey,
                    "metainfo" => $metainfo
                ));
            });
        });

        $router->get("/", function(){

            if( tool_exists( "website-analysis" ) ){
                require_once TOOLS_PATH . "website-analysis/functions.php";
            }

            $metainfo = apply_filters("ast/meta/info", "front", array());
            return View::render("dashboard", array(
                "metainfo" => $metainfo
            ));
        });

        $router->get(parse_route("toolcat", "{toolslug:[a-zA-Z0-9\-_]+}/"), function($toolslug){
            $categorydata = get_category_where(array(
                "slug" => $toolslug,
                "cat_of" => "tool"
            ));
            if( empty( $categorydata ) ){
                throw new HttpRouteNotFoundException("Invalid Categorys!!!");
            }

            $enableBeadcrum = apply_filters("ast/tool/category/breadcrumb", true);
            $metainfo = apply_filters("ast/meta/info", "category", $categorydata);
            return View::render("tool-category", array(
                "categorydata" => (object) $categorydata,
                "metainfo" => $metainfo,
                "enableBeadcrum" => $enableBeadcrum
            ));
        });

        $router->get(parse_route("tool", "{toolslug:[a-zA-Z0-9\-_]+}/"), function( $toolslug ){
            global $post;
            $post = get_post_by("slug", $toolslug);
            if( empty( $post ) || @$post->status == 'pending' ){
                throw new HttpRouteNotFoundException("Invalid Tool!!!");
            }

            /** REDIRECT IF INVALID POST TYPE OR THROW 404 PAGE */
            redirect_invalid_post($post, "tool");

            increasePostViews($post->id, $post->views);
            View::include_tool_functions($post->extra);

            $metaInfoBefore = apply_filters("ast/meta/post", $post, false);
            $metainfo = apply_filters("ast/meta/info", "tool", $metaInfoBefore);

            return View::render("single-tool", array(
                "tooldata" => $post, 
                "toolreport" => false,
                "metainfo" => $metainfo,
                "extraparams" => false,
                "output" => false
            ));
        });

        $router->get(parse_route("tool", "{toolslug:[a-zA-Z0-9_\-\.]+}/{tooltype:[a-zA-Z0-9_\-\.]+}/{typeslug:[a-zA-Z0-9_\-\.]+}/"), function( $toolslug, $tooltype, $typeslug ){
            global $post, $extraparams;
            $post = get_post_by("slug", $toolslug);
            if( empty( $post ) ){
                throw new HttpRouteNotFoundException("Invalid Tool!!!");
            }

            /** REDIRECT IF INVALID POST TYPE OR THROW 404 PAGE */
            redirect_invalid_post($post, "tool");

            /**GET TOOL REPORT */
            $toolreport = false;
            if( $tooltype == 'report' ){
                $toolreport = get_report($typeslug, $toolslug);
                if( empty( $toolreport ) ){
                    redirect(get_tool_url("slug", $toolslug));
                    exit;
                }
            }

            increasePostViews($post->id, $post->views);
            View::include_tool_functions($post->extra);

            $extraparams = (object) array(
                "option" => $tooltype,
                "value" => $typeslug 
            );

            $metaInfoBefore = apply_filters("ast/meta/post", $post, $extraparams);
            $metainfo = apply_filters("ast/meta/info", "tool", $metaInfoBefore);
            
            return View::render("single-tool", array(
                "tooldata" => $post, 
                "toolreport" => $toolreport,
                "metainfo" => $metainfo,
                "extraparams" => $extraparams,
                "output" => false
            ));
        });

        $router->get(parse_route("page", "{pageslug:[a-zA-Z0-9\-_]+}/"), function( $pageslug ){
            global $post;
            $post = get_post_by("slug", $pageslug);
            if( empty( $post ) ){
                throw new HttpRouteNotFoundException("Invalid Page!!!");
            }

            /** REDIRECT IF INVALID POST TYPE OR THROW 404 PAGE */
            redirect_invalid_post($post, "page");

            increasePostViews($post->id, $post->views);
            $metainfo = apply_filters("ast/meta/info", "page", $post);
            return View::render("single-page", array(
                "tooldata" => $post,
                "metainfo" => $metainfo
            ));
        });

        function front_router_blog( $page = 1 ){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Blog - %sitename%",
                "description" => "Complete SEO tips for optimization of your web content. Learn, implement and rank with our latest seo blog posts.",
                "link" => get_site_url("blog/")
            ));

            return View::render("blog", array(
                "metainfo" => $metainfo,
                "paged" => $page
            ));
        }
        $router->get(parse_route("blogs", "/"), function( ){
            return front_router_blog();
        });

        $router->get(parse_route("blogs", "/paged/{page:[0-9]+}/"), function($page){
            return front_router_blog($page);
        });

        $router->get("search/", function( ){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Search Any Tool - %sitename%",
                "description" => "Search any seo tools from text content tools, website management tools, domain tools",
                "link" => get_site_url("search/")
            ));
            return View::render("search", array(
                "metainfo" => $metainfo
            ));
        });

        $router->get("contact/", function( ){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Contact Us - 24/7 Support - %sitename%",
                "description" => "Do you have any questions about our tools? Call us now or email us at %adminemail%",
                "link" => get_full_url(true)
            ));
            return View::render("contact", array(
                "metainfo" => $metainfo
            ));
        });

        $router->get("pricing/", function( ){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Pricing & Plan - %sitename%",
                "description" => "Discover our competitive pricing options for our range of services. Find the perfect plan to suit your needs on our pricing page.",
                "link" => get_full_url(true)
            ));
            return View::render("pricing", array(
                "metainfo" => $metainfo
            ));
        });

        $router->get("payment/received/{orderid}/", function($orderid){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Payment Received - %sitename%",
                "description" => "Securely complete your purchase and explore our flexible pricing options on our checkout page.",
                "link" => get_full_url(true)
            ));

            global $db;
            $db->where("id", $orderid);
            $order = $db->objectBuilder()->getOne("orders");
            if( empty( $order ) ){
                throw new HttpRouteNotFoundException("Invalid Page!!!");
            }

            return View::render("parts.template.checkout-received", array(
                "metainfo" => $metainfo,
                "orderid" => $orderid,
                "order" => $order
            ));
        });

        $router->get("payment/checkout/{ordertype}/{orderid}/", function( $ordertype, $orderid ){
            $metainfo = apply_filters("ast/meta/info", "custom", (object) array(
                "title" => "Checkout - %sitename%",
                "description" => "Securely complete your purchase and explore our flexible pricing options on our checkout page.",
                "link" => get_full_url(true)
            ));
            
            global $db;
            $db->where("id", $orderid);
            $order = $db->objectBuilder()->getOne("posts");
            if( empty( $order ) || @$order->extra != 'plan' ){
                throw new HttpRouteNotFoundException("Invalid Page!!!");
            }

            //check user login or not
            if( ! is_user_loggin() ){
                $redirect_url = get_site_url("auth/login/?redirect_url=") . get_redirect_url();
                redirect($redirect_url);
                exit;
            }

            View::$customPage = "checkout";
            return View::render("parts.template.checkout", array(
                "metainfo" => $metainfo,
                "ordertype" => $ordertype,
                "order" => $order,
                "user" => ast_get_current_user()
            ));
        });

        $router->get(parse_route("blog", "{articleslug:[a-zA-Z0-9\-_]+}/"), function( $articleslug ){
            global $post;
            $post = get_post_by("slug", $articleslug);
            if( empty( $post ) ){
                throw new HttpRouteNotFoundException("Invalid Page!!!");
            }

            /** REDIRECT IF INVALID POST TYPE OR THROW 404 PAGE */
            redirect_invalid_post($post, "post");

            increasePostViews($post->id, $post->views);
            $metainfo = apply_filters("ast/meta/info", "post", $post);
            return View::render("single-post", array(
                "postdata" => $post,
                "metainfo" => $metainfo
            ));
        });

        $router->get("download/{downloadsession:[a-zA-Z0-9]+}/", function( $downloadsession ){
            $data = Download::get_data( $downloadsession );
            if( empty( $data ) ){
                throw new HttpRouteNotFoundException("Invalid Page!!!");
            }

            $settings = get_download_settings();
            
            $countdown = intval(@$settings->time);
            $countdown = $countdown >= 0 ? $countdown : 0;
            if( ! filter_var( $settings->enable, FILTER_VALIDATE_BOOLEAN ) ){
                if( isset( $data['chunked'] ) && !empty( $data['chunked'] ) ){
                    set_time_limit(0);
                    ini_set("zlib.output_compression", "Off");
                    Download::start_download( $data );
                    die();
                }
                
                redirect( $data['url'] );
                exit;
            }

            if( isset( $_GET['start'] ) || $countdown == 0 ){
                set_time_limit(0);
                ini_set("zlib.output_compression", "Off");
                Download::start_download( $data );
                die();
            }
            
            return View::render("download", array(
                "settings" => $settings,
                "filedata" => $data,
                "countdown" => $countdown,
                "downloadurl" => get_site_url("download/$downloadsession/")
            ));
        });

        $router->get("callback/{callbacktype}/", function($callbacktype){
            do_action("tkp/callback/$callbacktype");
            return false;
        });

        $router->post("callback/{callbacktype}/", function($callbacktype){
            do_action("tkp/callback/$callbacktype");
            return false;
        });

        $router->get("feed/", function(){
            do_action("tkp/feed/content");
            return false;
        });

        $router->get("assets/icon/{svgof}/{toolslug}/", function($svgof, $toolslug){
            do_action("tkp/svg/icon", $toolslug, $svgof);
            die();
        });

        /**
         * Add Additional Routes to Admin
         */
        do_action("ast/front/route", $router);
    });

});