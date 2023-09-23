<?php

use AST\View;
use AST\FileSystem;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

$router->group(["prefix" => "admin", 'before' => 'auth'], function(RouteCollector $router){
    $router->group(['before' => 'isValidUser'], function(RouteCollector $router){
        $router->get("/", function(){
            return View::render("dashboard");
        });
    
        $router->get("post/", function(){
            return View::render("post.index");
        });
    
        $router->get("post/add/", function(){
            return View::render("post.add");
        });
    
        $router->get("post/edit/{id:\d+}/", function( $id ){
            $postdata = get_post($id);
            if( empty( $postdata ) ){
                throw new HttpRouteNotFoundException("Invalid Post ID!!!");
            }

            $featuredimage = get_meta( "post", $postdata->id, "featured_image", false );
            $category = get_meta( "post", $postdata->id, "category", array() );
            return View::render("post.edit", array(
                "postdata" => $postdata,
                "featuredimage" => $featuredimage,
                "category" => $category
            ));
        });

        $router->get("post/category/", function(){
            return View::render("post.category", array(
                "categorydata" => false
            ));
        });

        $router->get("post/category/edit/{catid:\d+}/", function($catid){
            $category = get_category($catid);
            if( empty( $category ) ){
                throw new HttpRouteNotFoundException("Invalid Post Category ID!!!");
            }
            
            return View::render("post.category", array(
                "categorydata" => (object) $category
            ));
        });
    
        $router->get("page/", function(){
            return View::render("page.index");
        });
    
        $router->get("page/add/", function(){
            return View::render("page.add");
        });
    
        $router->get("page/edit/{id:\d+}/", function( $id ){
            $pagedata = get_post($id);
            if( empty( $pagedata ) ){
                throw new HttpRouteNotFoundException("Invalid Page ID!!!");
            }

            $featuredimage = get_meta( "page", $pagedata->id, "featured_image", false );
            return View::render("page.edit", array(
                "pagedata" => $pagedata,
                "featuredimage" => $featuredimage
            ));
        });

        $router->get("plan/", function(){
            return View::render("plans.index");
        });

        $router->get("plan/add/", function(){
            return View::render("plans.add");
        });

        $router->get("plan/settings/", function(){
            return View::render("plans.settings");
        });

        $router->get("plan/payments/", function(){
            return View::render("plans.payments");
        });

        $router->get("plan/edit/{id:\d+}/", function($id){
            $pagedata = get_post($id);
            if( empty( $pagedata ) ){
                throw new HttpRouteNotFoundException("Invalid Page ID!!!");
            }

            return View::render("plans.edit", array(
                "pagedata" => $pagedata,
                "metadata" => get_all_meta("plan", $id)
            ));
        });
    
        $router->get("media/", function(){
            return View::render("media");
        });
    
        $router->get("interface/", function(){
            return View::render("interface.index");
        });

        $router->get("interface/colors/", function(){
            return View::render("interface.colors");
        });
    
        $router->get("interface/menus/", function(){
            return View::render("interface.menus");
        });

        $router->get("interface/footermenus/", function(){
            return View::render("interface.footermenus");
        });

        $router->get("mail/", function(){
            return View::render("mail.index");
        });

        $router->get("mail/template/", function(){
            return View::render("mail.template");
        });
    
        $router->get("mail/settings/", function(){
            return View::render("mail.settings");
        });
    
        $router->get("tool/", function(){
            return View::render("tool.index");
        });

        $router->get("tool/edit/{id:\d+}/", function( $id ){
            $tooldata = get_post($id);
            if( empty( $tooldata ) ){
                throw new HttpRouteNotFoundException("Invalid Tool ID!!!");
            }
            
            View::include_tool_functions($id);

            $faqQuestions = get_meta("tool", $tooldata->id, "faqQuestions", []);
            $featuredimage = get_tool_icon($tooldata->id, $tooldata->slug, false);
            // $featuredimage = get_meta( "tool", $tooldata->id, "featured_image" );
            $category = get_meta( "tool", $tooldata->id, "category", array() );
            $sort = get_meta( "tool", $tooldata->id, "sort", "0" );
            $views = get_meta( "tool", $tooldata->id, "views", "0" );
            return View::render("tool.edit", array(
                "tooldata" => $tooldata,
                "featuredimage" => $featuredimage,
                "category" => $category,
                "sort" => $sort,
                "views" => $views,
                "faqQuestions" => $faqQuestions
            ));
        });

        $router->get("tool/add/", function(){
            return View::render("tool.add");
        });

        $router->get("tool/category/", function(){
            return View::render("tool.category", array(
                "categorydata" => false
            ));
        });

        $router->get("tool/category/edit/{id:\d+}/", function( $id ){
            $category = get_category($id);
            if( empty( $category ) ){
                throw new HttpRouteNotFoundException("Invalid Tool Category ID!!!");
            }
            
            return View::render("tool.category", array(
                "categorydata" => (object) $category
            ));
        });

        $router->get("user/", function(){
            return View::render("user.index");
        });

        $router->get("user/edit/{id:\d+}/", function( $id ){
            $user = get_user( $id );
            if( empty( $user ) ){
                throw new HttpRouteNotFoundException("Invalid User ID!!!");
            }

            $featuredimage = get_meta( "user", $user->id, "featured_image" );
            return View::render("user.edit", array(
                "user" => $user,
                "featuredimage" => $featuredimage
            ) );
        });

        $router->get("user/add/", function(){
            return View::render("user.add");
        });

        $router->get("user/profile/", function(){
            $user = get_user( );
            if( empty( $user ) ){
                throw new HttpRouteNotFoundException("Invalid User ID!!!");
            }

            $featuredimage = get_meta( "user", $user->id, "featured_image" );
            return View::render("user.edit", array(
                "user" => $user,
                "featuredimage" => $featuredimage
            ) );
        });

        $router->get("sitemap/", function(){
            return View::render("sitemap");
        });

        $router->get("setting/", function(){
            return View::render("setting.index");
        });

        $router->get("setting/permalink/", function(){
            return View::render("setting.permalink");
        });

        $router->get("setting/sitemap/", function(){
            return View::render("setting.sitemap");
        });

        $router->get("setting/maintenance/", function(){
            return View::render("setting.maintenance");
        });

        $router->get("setting/download/", function(){
            return View::render("setting.download");
        });

        $router->get("plugins/", function(){
            return View::render("plugins");
        });

        $router->get("api-keys/", function(){
            return View::render("apikeys");
        });
        
        $router->get("advance/cron/", function(){
            return View::render("advance.cron");
        });

        $router->get("advance/robots/", function(){
            return View::render("advance.robots");
        });

        $router->get("advance/minification/", function(){
            return View::render("advance.minification");
        });

        $router->get("advance/error/", function(){
            return View::render("advance.error");
        });

        $router->get("advance/php-info/", function(){
            return View::render("advance.php-info");
        });

        $router->get("tool/add/copy/", function(){
            global $db;
            $supportstools = array();

            foreach($supportstools as $tool){
                $toolslug = title_to_slug( $tool );
                $tooldata = get_post_by( "slug", $toolslug );
                
                if( empty( $tooldata ) ){
                    $toolPart = explode("to", $tool);
                    $fromc = trim($toolPart[0]);
                    $toc = trim($toolPart[1]);
                    $from = strtolower($fromc);
                    $to = strtolower($toc);

                    $findKey = array("{{SLUG}}", "{{fromc}}", "{{toc}}", "{{from}}", "{{to}}");
                    $replaceValue = array($toolslug, $fromc, $toc, $from, $to);

                    $toolDir = TOOLS_PATH . "$toolslug/";
                    if( ! file_exists( $toolDir ) ){
                        if( FileSystem::create($toolDir, true) ){

                            /** Functions.php */
                            $functions = file_get_contents(TOOLS_PATH . "image-converter-template/functions.php");
                            $functions = str_replace($findKey, $replaceValue, $functions);
                            FileSystem::write($toolDir . "functions.php", $functions);

                            /** Icon.svg */
                            $icon = file_get_contents(TOOLS_PATH . "image-converter-template/icon.svg");
                            $icon = str_replace($findKey, $replaceValue, $icon);
                            FileSystem::write($toolDir . "icon.svg", $icon);

                            /** Description */
                            $description = file_get_contents(TOOLS_PATH . "image-converter-template/desc.txt");
                            $description = str_replace($findKey, $replaceValue, $description);

                            //update on database
                            $inserID = $db->insert("posts", array(
                                "title" => $tool,
                                "slug" => $toolslug,
                                "extra" => $toolslug,
                                "author" => 1,
                                "description" => $description,
                                "status" => "active",
                                "type" => "tool",
                                "date" => date("Y-m-d h:i:s"),
                                "modified" => date("Y-m-d h:i:s")
                            ));


                            $seoTitle = "{{fromc}} to {{toc}} Converter: Convert {{fromc}} to {{toc}} For Free";
                            $seoTitle = str_replace($findKey, $replaceValue, $seoTitle);

                            $seoDesc = "Our {{fromc}} to {{toc}} converter tool is the ultimate solution for transforming {{fromc}} images to high-quality {{toc}} format for free.";
                            $seoDesc = str_replace($findKey, $replaceValue, $seoDesc);

                            update_meta("tool", $inserID, "seo_title", $seoTitle);
                            update_meta("tool", $inserID, "seo_des", $seoDesc);
                            update_meta("tool", $inserID, "category", 'a:1:{i:0;s:2:"11";}');
                            update_meta("tool", $inserID, "featured_image", '');
                            update_meta("tool", $inserID, "seo_keywords", '%seokeywords%');
                            
                            echo $tool . " => Inserted Successfully" . PHP_EOL;
                        }else{
                            echo $tool . " => Unable to create Directory" . PHP_EOL;
                        }
                    }else{
                        echo $tool . " => File Already Exists" . PHP_EOL;
                    }
                }else{
                    echo $tool . " => Data Already Exists" . PHP_EOL;
                }
            }
        });

        $router->get("tool/add/{tooltitle}/{tooltemplate}/", function($tooltitle, $tooltemplate){
            $tooltitle = urldecode($tooltitle); 
            $template = urldecode($tooltemplate); 

            $toolslug = title_to_slug( $tooltitle );
            global $db;
            
            $tool = get_post_by( "slug", $template );
            if( empty( $tool ) ){
                die("Template doesn't exists");
            }

            $tooldata = get_post_by( "slug", $toolslug );
            if( empty( $tooldata ) ){
                $dst = TOOLS_PATH . $toolslug . "/";
                $src = TOOLS_PATH . "$template/";
                FileSystem::copy_folder($src, $dst);

                if( file_exists( $dst )  ){
                    $files = glob($dst . '*.{php,js}', GLOB_BRACE);
                    foreach($files as $file){
                        $fileContent = file_get_contents( $file );

                        $find = array($tool->slug, str_replace("-", "_", $tool->slug), $tool->title);
                        $replace = array($toolslug, str_replace("-", "_", $toolslug), $tooltitle);
                        $fileContent = str_replace($find, $replace, $fileContent);
                        file_put_contents($file, $fileContent);
                    }
                    
                    $inserID = $db->insert("posts", array(
                        "title" => $tooltitle,
                        "slug" => $toolslug,
                        "extra" => $toolslug,
                        "author" => 1,
                        "description" => $tool->description,
                        "status" => "active",
                        "type" => "tool",
                        "date" => date("Y-m-d h:i:s"),
                        "modified" => date("Y-m-d h:i:s")
                    ));

                    $seoTitle = get_meta("tool", $tool->id, "seo_title", "%seotitle% %sep% %sitename%");
                    $seoDesc = get_meta("tool", $tool->id, "seo_des", "%seodes%");

                    update_meta("tool", $inserID, "seo_title", $seoTitle);
                    update_meta("tool", $inserID, "seo_des", $seoDesc);

                    $schemaData = get_meta("tool", $tool->id, "schema_steps_data");
                    if( !empty( $schemaData ) ){
                        update_meta("tool", $inserID, "schema_steps_data", $schemaData);
                    }

                    $schemaTitle = get_meta("tool", $tool->id, "schema_steps_title");
                    if( !empty( $schemaTitle ) ){
                        update_meta("tool", $inserID, "schema_steps_title", $schemaTitle);
                    }

                    $schemaSupply = get_meta("tool", $tool->id, "schema_steps_supply");
                    if( !empty( $schemaSupply ) ){
                        update_meta("tool", $inserID, "schema_steps_supply", $schemaSupply);
                    }

                    $faq = get_meta("tool", $tool->id, "faqQuestions");
                    if( !empty( $faq ) ){
                        update_meta("tool", $inserID, "faqQuestions", $faq);
                    }
                    

                    header("Location:" . get_site_url("admin/tool/edit/$inserID/"));
                    die();
                }else{
                    return "Already Exists";
                }
            }else{
                return "Already Exists";
            }
            
            return null;
        });

        /**
         * Add Additional Routes to Admin
         */
        do_action("ast/admin/route", $router);
    });

    $router->get("noaccess/", function(){
        return View::render("noaccess");
    });
});