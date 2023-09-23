<?php

use AST\FileSystem;
use AST\Cookie;
use AST\Helper\Sitemap;

add_action("ajax/req/remove_plugins", "ajax_remove_remove_plugins_admin");
function ajax_remove_remove_plugins_admin(){
    if( isset( $_POST['plugin'] ) && isset( $_POST['plugin'] ) ){
        $plugins = trim($_POST['plugin']);

        $pluginPath = PLUGINS_PATH . $plugins . "/";
        if( file_exists( $pluginPath ) ){
            if( FileSystem::delete($pluginPath, true) ){
                ast_send_json(array(
                    "success" => true,
                    "message" => "Plugin Removed Successfully!!!"
                ));
            }else{
                ast_send_json(array(
                    "success" => false,
                    "message" => "Unable to remove plugin. Please try Again!!!"
                ));
            }
        }else{
            ast_send_json(array(
                "success" => false,
                "message" => "Plugin Doesn't exists!!!"
            ));
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Unable to identify Plugin!!!"
        ));
    }
}

add_action("ajax/req/get_content_from_url", "allsmarttools_get_content_from_url");
add_action("ajax/req/nologin/get_content_from_url", "allsmarttools_get_content_from_url");
function allsmarttools_get_content_from_url(){
    if( isset( $_POST['url'] ) && !empty( $_POST['url'] ) ){
        $url = trim($_POST['url']);

        $response = getRequestWithContent($url);
        if( $response && !empty( $response['content'] ) ){
            ast_send_json($response);
        }
    }

    ast_send_json(array(), 500);
}

/**
 * Update Settings
 * 
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Ajax
 */
add_action("ajax/req/update_site_settings", "allsmarttools_update_site_settings");
function allsmarttools_update_site_settings(){
    $output = array(
        "success" => false,
        "message" => "Unable to Update Settings. Please try again!!!"
    );

    if( isset($_POST['settings']) && !empty($_POST['settings']) ){

        if( isset( $_POST['settings']['ast-crf-validation'] ) ){
            unset($_POST['settings']['ast-crf-validation']);
        }

        $settingskey = trim($_POST['dataof']);
        if( update_settings($settingskey, $_POST['settings']) ){
            do_action("tkp/update/setttings", $settingskey);
            $output = array(
                "success" => true,
                "message" => "Settings updated successfully!!!"
            );
        }
        
    }

    ast_send_json($output);
}


add_action("ajax/req/manual_minification", "allsmarttools_minify_scripts_settings");
function allsmarttools_minify_scripts_settings(){
    $output = array(
        "success" => true,
        "message" => "All Scripts minified successfully. Make sure disable debug mode!!!"
    );

    /** Start minification */
    require_once HELPER_PATH . "Minification.php";
    (new \AST\Helper\Minification())->minify();
    

    ast_send_json($output);
}

/**
 * Generate XML Sitemap
 * 
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Ajax
 */
add_action("ajax/req/generate_admin_sitemap", "allsmarttools_generate_admin_sitemap");
function allsmarttools_generate_admin_sitemap(){
    $output = array(
        "success" => false,
        "message" => "Unable to generate sitemap. Please try again!!!"
    );

    $sitemap = Sitemap::instance();
    if( $sitemap->start() ){
        $output = array(
            "success" => true,
            "message" => "Sitemap Generated Sucessfully!!!"
        );
    }

    ast_send_json($output);
}

/**
 * Core class used to implement ajax functionality.
 *
 * @since 1.0
 * @package AllSmartTools
 * @subpackage Ajax
 */
add_action("ajax/req/get_user_details", "allsmarttools_get_user_details");
add_action("ajax/req/nologin/get_user_details", "allsmarttools_get_user_details");
function allsmarttools_get_user_details(){
    global $db;
    $s = isset( $_POST['search'] ) && !empty( $_POST['search'] ) ? trim($_POST['search']) : "";

    $output = [];

    if( ! empty( $s ) ){
        $db->where("(`name` LIKE ? or `email` LIKE ?)", Array("%$s%", "%$s%"));
    }

    $users = $db->arraybuilder()->get("users", 10);
    if( ! empty( $users ) ){
        foreach($users as $k => $v){
            $output[] = array(
                'id' => $v['id'],
                'text' => $v['email']
            );
        }
    }
    
    ast_send_json($output);
}

add_action("ajax/req/get_tool_details", "allsmarttools_get_tool_details");
add_action("ajax/req/nologin/get_tool_details", "allsmarttools_get_tool_details");
function allsmarttools_get_tool_details(){
    global $db;
    $s = isset( $_POST['search'] ) && !empty( $_POST['search'] ) ? trim($_POST['search']) : "";

    $output = array(
        array(
            "id" => "all",
            "text" => "All Tools"
        )
    );

    if( ! empty( $s ) ){
        $db->where("(`title` LIKE ? or `description` LIKE ?)", Array("%$s%", "%$s%"));
    }

    $db->where("type", "tool");
    $users = $db->arraybuilder()->get("posts", 10);
    if( ! empty( $users ) ){
        foreach($users as $k => $v){
            $output[] = array(
                'id' => $v['id'],
                'text' => $v['title']
            );
        }
    }
    
    ast_send_json($output);
}

add_action("ajax/req/get_category_ajax", "allsmarttools_get_category_ajax");
function allsmarttools_get_category_ajax(){
    global $db;
    $s = isset( $_POST['search'] ) && !empty( $_POST['search'] ) ? trim($_POST['search']) : "";
    $typeof = isset( $_POST['typeof'] ) && !empty( $_POST['typeof'] ) ? trim($_POST['typeof']) : "tool";
    $output = [];


    $db->where("cat_of", $typeof);
    if( ! empty( $s ) ){
        $db->where("(title LIKE ? or description LIKE ?)", Array("%$s%", "%$s%"));
    }

    $categories = $db->get("category", 10);
    if( ! empty( $categories ) ){
        foreach($categories as $k => $v){
            $output[] = array(
                'id' => $v->id,
                'text' => $v->title
            );
        }
    }
    
    ast_send_json($output);
}


add_action("ajax/req/publish_update_post", "allsmarttools_publish_update_post");
function allsmarttools_publish_update_post(){
    $output = array();
    global $db;

    if( isset( $_POST["post_title"] ) && !empty( $_POST["post_title"] ) ){
        $title = trim( $_POST['post_title'] );
        $slug = isset( $_POST['post_slug'] ) && !empty( $_POST['post_slug'] ) ? strtolower($_POST['post_slug']) : title_to_slug( $title );
        $des = isset( $_POST['post_des'] ) ? trim($_POST['post_des']) : "";
        $postId = isset( $_POST['post_id'] ) ? trim($_POST['post_id']) : "";
        $image = isset( $_POST['featured_image'] ) ? trim($_POST['featured_image']) : "";
        $status = isset( $_POST['post_status'] ) ? trim($_POST['post_status']) : "active";
        $type = isset( $_POST['post_type'] ) ? trim($_POST['post_type']) : "post";
        $author = get_current_id();

        $insertargs = array(
            "title" => $title,
            "slug" => $slug,
            "description" => $des,
            "status" => $status,
            "type" => $type,
            "date" => date("Y-m-d h:i:s"),
            "modified" => date("Y-m-d h:i:s"),
            "author" => $author
        );

        $metaData = isset($_POST['meta']) ? $_POST['meta'] : array();
        $metaData = apply_filters("ast/post/before/update", $metaData);
        do_action("ast/post/before/update", $metaData);

        if( empty( $postId ) ){
            $result = insert_post($insertargs, $type);
            if( $result['success'] ){
                update_meta($type, $result['postid'], "featured_image", $image);

                if( isset( $metaData ) && !empty($metaData) ){
                    foreach($metaData as $key => $value){
                        update_meta($type, $result['postid'], $key, $value);
                    }
                }

                do_action("tkp/after/update/post", $result['postid'], $insertargs);
                $output = array(
                    "success" => true,
                    "message" => "Inserted Successfull!!",
                    "url" => get_site_url(sprintf("admin/%s/edit/%s/", $type, $result['postid']))
                );
            }else{
                $output = $result;
            }
        }else{
            unset($insertargs['date']);
            if(isset($insertargs['extra'])){
                unset($insertargs['extra']);
            }
            $result = update_post($insertargs, array(
                "id" => $postId
            ));

            if( $result ){
                update_meta($type, $postId, "featured_image", $image);
                if( isset( $metaData ) && !empty($metaData) ){
                    foreach($metaData as $key => $value){
                        update_meta($type, $postId, $key, $value);
                    }
                }

                do_action("tkp/after/update/post", $postId, $insertargs);
                $output = array(
                    "success" => true,
                    "message" => "Page Updated"
                );
            }else{
                $output = array(
                    "success" => false,
                    "message" => $result
                );
            }
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Page Title is Required!!!"
        );
    }

    ast_send_json($output);
}

add_action("ajax/req/update_robots_txt", function(){
    $output = array(
        "success" => false,
        "type" => "error",
        "message" => "Your robots.txt content is empty!!!"
    );

    if( isset( $_POST['content'] ) && !empty( $_POST['content'] ) ){
        $robotFile = ASTROOTPATH . "robots.txt";
        if( \AST\FileSystem::write($robotFile, $_POST['content']) ){
            $output = array(
                "success" => true,
                "type" => "success",
                "message" => "Your robots.txt file is updated successfully!!!"
            );
        }else{
            $output = array(
                "success" => false,
                "type" => "error",
                "message" => "Unable to update robots.txt file!!!"
            );
        }
    }

    ast_send_json($output);
});

add_action("ajax/req/publish_update_user", "allsmarttools_publish_update_user");
function allsmarttools_publish_update_user(){
    $output = array();
    global $db;

    if( isset( $_POST["user_id"] ) ){
        $email = isset($_POST['email']) ? trim( $_POST['email'] ) : "";
        $name = trim( $_POST['name'] );
        $password = trim( $_POST['password'] );

        if( isset( $_POST['cpassword'] ) && !empty( $_POST['cpassword'] ) ){
            if( trim($_POST['cpassword']) != $password ){
                ast_send_json(array(
                    "success" => false,
                    "message" => "Confirm Password Doesn't match!!!"
                ));
            }
        }

        $userId = isset( $_POST['user_id'] ) ? trim($_POST['user_id']) : "";
        $insertargs = [
            "email" => $email,
            "name" => $name,
            "password" => $password
        ];

        if( isset( $_POST['status'] ) && !empty($_POST['status']) ){
            $insertargs['status'] = trim($_POST['status']);
        }

        if( isset( $_POST['role'] ) && !empty($_POST['role']) ){
            $insertargs['role'] = trim($_POST['role']);
        }

        if( empty( $userId ) ){
            $result = insert_user($insertargs);
            if( $result['success'] ){
                if( isset( $_POST['meta'] ) && !empty($_POST['meta']) ){
                    foreach($_POST['meta'] as $key => $value){
                        update_meta("user", $result['userid'], $key, $value);
                    }
                }

                $output = [
                    "success" => true,
                    "message" => "Inserted Successfull!!",
                    "url" => get_site_url(sprintf("admin/user/edit/%s", $result['userid']))
                ];
            }else{
                $output = $result;
            }
        }else{
            if( isset( $insertargs['email'] ) ){
                unset($insertargs['email']);
            }
            
            $result = update_user($insertargs, [
                "id" => $userId
            ]);

            if( $result ){
                if( isset( $_POST['meta'] ) && !empty($_POST['meta']) ){
                    foreach($_POST['meta'] as $key => $value){
                        update_meta("user", $userId, $key, $value);
                    }
                }
                $output = [
                    "success" => true,
                    "message" => "User Updated Successfully!!!"
                ];
            }else{
                $output = [
                    "success" => false,
                    "message" => $result
                ];
            }
        }
    }else{
        $output = [
            "success" => false,
            "message" => "User Email is Required!!!"
        ];
    }

    ast_send_json($output);
}

add_action("ajax/req/nologin/ast_login", "ast_login_from_login_page");
function ast_login_from_login_page(){
    $output = array();
    global $db;

    if( isset( $_POST['username'] ) && !empty( $_POST['username'] ) ){
        $username = $_POST['username'];
        $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : get_site_url();

        if( isset( $_POST['password'] ) && !empty( $_POST['password'] ) ){
            $password = $_POST['password'];
            $rememberme = isset($_POST['remember']) ? trim($_POST['remember']) : "off";
            $rememberme = filter_var($rememberme, FILTER_VALIDATE_BOOLEAN);

            if( filter_var( $username, FILTER_VALIDATE_EMAIL ) ){
                $user = get_user_by("email", $username);
            }else{
                $user = get_user_by("username", $username);
            }
            
            if( ! empty( $user ) ){
                if( verify_password($password, $user->password) ){
                    set_user_logedin($user->id, $rememberme);
                    $output = array(
                        "success" => true,
                        "message" => "Login Successfully. Redirecting . . .",
                        "url" => $redirect_url,
                        "timeout" => 2000
                    );
                }else{
                    $output = array(
                        "success" => false,
                        "message" => "Username and Password doesn't match!!!"
                    );
                }
            }else{
                $output = array(
                    "success" => false,
                    "message" => "User doesn't found with this username or email!!!"
                );
            } 
        }else{
            $output = array(
                "success" => false,
                "message" => "Password is required!!!"
            );
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Username is required!!!"
        );
    }

    ast_send_json($output);
}

add_action("ajax/req/delete_data_from_db", "allsmart_tools_delete_data_from_db");
function allsmart_tools_delete_data_from_db(){
    global $db;
    $output = array(
        "success" => false,
        "message" => "Unable to Delete data from database!!!"
    );

    if( isset( $_POST['delete_from'] ) && !empty($_POST['delete_from']) ){
        $from = trim($_POST['delete_from']);

        if( isset( $_POST['delete_id'] ) && !empty($_POST['delete_id']) ){
            $id = trim($_POST['delete_id']);

            try{
                do_action("ast/before/delete/data/", $from, $id);

                if( $db->delete($from, array(
                    "id" => $id
                )) ){
                    if( $from == 'posts' ){
                        $db->deleteByCondition("meta_data", array(
                            "(`meta_of` = ? OR `meta_of` = ?) AND `meta_id` = ?",
                            array( "post", "page", $id )
                        ));
                    }
                    
                    do_action("ast/delete/data/", $from, $id);

                    ast_send_json(array(
                        "success" => true,
                        "message" => "Data deleted successfully from database!!!"
                    ));
                }else{
                    ast_send_json(array(
                        "success" => false,
                        "message" => $db->getLastError()
                    ));
                }
            }catch(Exception $e){
                ast_send_json(array(
                    "success" => false,
                    "message" => $e->getMessage()
                ));
            }
        }
    }

    ast_send_json($output);
}


add_action("ajax/req/add_category", "allsmarttools_add_category");
function allsmarttools_add_category(){
    global $db;
    if( isset( $_POST['cat_title'] ) && !empty( $_POST['cat_title'] ) ){
        $title = trim($_POST['cat_title']);
        $slug = title_to_slug( $title );
        $cat_des = isset($_POST['cat_des']) ? trim($_POST['cat_des']) : "";
        $cat_of = isset($_POST['cat_of']) ? trim($_POST['cat_of']) : "";
        $cat_id = isset($_POST['cat_id']) ? trim($_POST['cat_id']) : "";

        $db->where("(`cat_of` = ? AND `slug` = ?)", array("tool", $slug));
        $results = $db->get("category", 1);
        if( !empty( $results ) && count($results) > 0 ){
            $results = $results[0];
            $cat_id = $results->id;
        }

        $metaData = isset($_POST['meta']) ? $_POST['meta'] : array();
        $metaData = apply_filters("ast/category/before/update", $metaData);
        do_action("ast/category/before/update", $metaData);

        $insertargs = array(
            "title" => $title,
            "slug" => $slug,
            "description" => $cat_des,
            "cat_of" => $cat_of
        );
        if( empty( $cat_id ) && empty( $results ) ){
            $insert = $db->insert("category", $insertargs);

            if( $insert ){
                $output = array(
                    "success" => true,
                    "message" => "Category Inserted!!!",
                    "url" => get_site_url() . "admin/$cat_of/category/"
                );
            }else{
                $output = array(
                    "success" => false,
                    "message" => $db->getLastError()
                );
            }


        }else{
            unset($insertargs['slug']);
            if( $db->update("category", $insertargs, array(
                "id" => $cat_id
            ))){
                foreach($metaData as $key => $value)
                    update_meta("category", $cat_id, $key, $value);

                $output = array(
                    "success" => true,
                    "message" => "Category Updated!!!",
                    "url" => get_site_url() . "admin/$cat_of/category/"
                );
            }else{
                $output = array(
                    "success" => false,
                    "message" => $db->getLastError()
                );
            }
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Category Title is Required!!!"
        );
    }

    ast_send_json($output);
}

add_action( "ajax/req/send_user_reset_password_link", "ast_ajax_send_user_password_reset_link" );
add_action( "ajax/req/nologin/send_user_reset_password_link", "ast_ajax_send_user_password_reset_link" );
function ast_ajax_send_user_password_reset_link(){
    if( isset( $_POST['userid'] ) && !empty( $_POST['userid'] ) ){
        $output = send_user_password_reset_link($_POST['userid']);
    }else{
        $output = array(
            "success" => false,
            "message" => "User Email is invalid!!!"
        );
    }

    ast_send_json($output);
}

add_action( "ajax/req/send_user_email_activation_link", "ast_send_user_email_activation_link" );
function ast_send_user_email_activation_link(){
    if( isset( $_POST['userid'] ) && !empty( $_POST['userid'] ) ){
        $output = send_user_email_activation($_POST['userid']);
    }else{
        $output = array(
            "success" => false,
            "message" => "User ID is invalid!!!"
        );
    }

    ast_send_json($output);
}

add_action("ajax/req/authcode_reset_password", "ast_authcode_reset_password_frontpage");
add_action("ajax/req/nologin/authcode_reset_password", "ast_authcode_reset_password_frontpage");
function ast_authcode_reset_password_frontpage(){
    global $db;
    $output = array(
        "success" => false,
        "message" => "Unable to change your password. Please try once!!!"
    );

    if( isset( $_POST['authcode'] ) && !empty( $_POST['authcode'] ) ){
        $db->where("meta_key", "user_reset_password_key");
        $db->where("meta_value", trim($_POST['authcode']));

        $results = $db->objectBuilder()->get("meta_data", 1);
        if( !empty( $results ) && is_array($results) && count($results) > 0 ){
            $userID = $results[0]->meta_id;

            $password = isset($_POST['password']) ? trim($_POST['password']) : "";
            $cpassword = isset($_POST['cpassword']) ? trim($_POST['cpassword']) : "";

            if( !empty($password) && !empty($cpassword) && $password == $cpassword ){
                if( update_user(array(
                    "password" => $password
                ), array(
                    "id" => $userID
                ))){

                    //delete remove password
                    delete_meta("user", $userID, "user_reset_password_key");

                    $output = array(
                        "success" => true,
                        "message" => "Password changed successfully. Redirecting . . .",
                        "url" => get_site_url() . "auth/login/",
                        "timeout" => 3000
                    );
                }else{
                    $output = array(
                        "success" => false,
                        "message" => "Unable to change password!!!"
                    );
                }
            }else{
                $output = array(
                    "success" => false,
                    "message" => "Password doesn't match!!!"
                );
            }
        }else{
            $output = array(
                "success" => false,
                "message" => "Reset Authentication code doesn't exists!!!"
            );
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Reset Authentication code is missing!!!"
        );
    }

    ast_send_json($output);
}

add_action("ajax/req/update_route_settings", "ast_update_route_settings");
function ast_update_route_settings(){
    $validation = validate_all_routes( $_POST );
    if($validation  == "true" ){
        $consttext = file_get_contents( ASTROOTPATH . "app/routes/const-sample.php" );
        if( empty( $consttext ) ){
            ast_send_json(array(
                "success" => false,
                "message" => "Route Constant File is missing!!!"
            ));
        }

        $routevalues = all_routes_params();
        foreach($routevalues as $value => $text){
            if( isset( $_POST[$value] ) ){
                $key = sprintf("{{%s}}", $value);
                $consttext = str_replace($key, trim($_POST[$value]), $consttext);
            }
        }

        if( file_put_contents( ASTROOTPATH . "app/routes/const.php", $consttext ) ){
            ast_send_json(array(
                "success" => true,
                "message" => "Route Updated Successfully. Redirecting . . ."
            ));
        }else{
            ast_send_json(array(
                "success" => false,
                "message" => "Unable to write to file. Make sure you have given Read/Write permission to files."
            ));
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => $validation
        ));
    }
}


add_action("ajax/req/add_to_cart", "add_to_card_loggin");
function add_to_card_loggin(){
    if( 
        isset($_POST['plantype']) && !empty($_POST['plantype'])
        && isset($_POST['planid']) && !empty($_POST['planid'])
    ){
        $plantype = trim($_POST['plantype']);
        $planid = trim($_POST['planid']);
        $userid = get_current_id();

        global $db;
        $insertID = $db->insert("orders", array(
            "plan" => $planid,
            "user" => $userid,
            "type" => $plantype,
            "status" => "draft"
        ));
        if( $insertID ){
            ast_send_json(array(
                "success" => true,
                "url" => get_site_url("payments/checkout/$insertID/")
            ));
        }
    }
    
    ast_send_json(array(
        "success" => false,
        "message" => "unable to purchase subscription!!!"
    ));
}

add_action("ajax/req/nologin/add_to_cart", "add_to_card_logout");
function add_to_card_logout(){
    ast_send_json(array(
        "success" => false,
        "message" => "Please login to purchase the subscription!!!"
    ));
}

add_action("ajax/req/refresh_checkout_page", "tkp_refresh_checkout_page");
function tkp_refresh_checkout_page(){
    $orderid = intval($_POST['orderid']);
    $ordertype = trim($_POST['ordertype']);

    global $db;
    $db->where("id", $orderid);
    $order = $db->objectBuilder()->getOne("posts");
    if( empty( $order ) ){
        ast_send_json(array(
            "success" => false,
            "message" => "Order doesn't exists!!!"
        ));
    }

    ob_start();
    do_action("tkp/checkout/overview", $order, $ordertype);
    $overview = ob_get_clean();

    ob_start();
    do_action("tkp/checkout/payments", trim($_POST['gateway']), $order, $ordertype);
    $payments = ob_get_clean();

    ast_send_json(array(
        "success" => true,
        "payments" => $payments,
        "overview" => $overview
    ));
}

add_action("ajax/req/clear_paypal_data", "tkp_clear_paypal_data");
function tkp_clear_paypal_data(){
    global $db;
    $db->delete("meta_data", array( "meta_key" => "paypal_yearly_plan_id" ));
    $db->delete("meta_data", array( "meta_key" => "paypal_yearly_plan_data" ));
    $db->delete("meta_data", array( "meta_key" => "paypal_monthly_plan_id" ));
    $db->delete("meta_data", array( "meta_key" => "paypal_monthly_plan_data" ));
    $db->delete("settings", array( "option_name" => "paypal_product" ));
    
    ast_send_json(array(
        "success" => true,
        "message" => "Paypal data Cleared Successfully!!!"
    ));
}

add_action("ajax/req/update_paypal_payments", "tkp_update_update_paypal_payments_status");
function tkp_update_update_paypal_payments_status(){
    if( isset( $_POST['order']['subscriptionID'] ) ){
        $subID = trim($_POST['order']['subscriptionID']);

        include HELPER_PATH . "paypalSubscription.php";
        $paypal = new AST\Helper\paypalSubscription();
        $subscription = $paypal->getSubscription($subID);

        if( $subscription->success ){
            $status = strtolower($subscription->data->status);
            $status = str_replace("approval_", "", $status);

            global $db;
            $ordertype = trim($_POST['form']['ordertype']);
            $orderid = trim($_POST['form']['orderid']);
            $userid = get_current_id();

            $dateTime = new DateTime($subscription->data->billing_info->next_billing_time);
            $formattedExpiry = $dateTime->format('Y-m-d H:i:s');

            $insertID = $db->insert("orders", array(
                "plan" => $orderid,
                "user" => $userid,
                "type" => $ordertype,
                "status" => $status,
                "apikey" => generateApiKey(20),
                "response" => maybe_serialize($subscription->data),
                "source" => "paypal",
                "orderid" => $subID,
                "expiry" => $formattedExpiry,
                "date" => date("Y-m-d H:i:s")
            ));

            if( $insertID ){
                ast_send_json(array(
                    "success" => true,
                    "url" => get_site_url("payment/received/$insertID/")
                ));
            }else{
                ast_send_json(array(
                    "success" => false,
                    "message" => "Unable to purchase subscription!!!"
                ));
            }
        }else{
            ast_send_json($subscription);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Invalid Subscription Information!!!"
        ));
    }
}

//ajax table
require_once INCLUDE_PATH . "ajax-table.php";