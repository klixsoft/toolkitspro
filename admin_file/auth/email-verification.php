<?php
global $router;
global $db;
$params = $router->get_params();

$metainfo = false;
$userinfo = false;
if( isset( $params[2] ) && !empty($params[2]) ){
    $db->where("meta_key", "user_email_activation_key");
    $db->where("meta_value", $params[2]);
    $results = $db->objectBuilder()->get("meta_data", 1);
    if( !empty( $results ) && is_array($results) && count($results) > 0 ){
        $metainfo = $results[0];

        $userinfo = get_user(intval($metainfo->meta_id));
        update_user(array(
            "status" => "active"
        ), array(
            "id" => $userinfo->id
        ));
    }
}
?>

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo get_site_url(); ?>" target="_blank" class="h1">
                <?php echo get_site_logo_html(); ?>
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                    if( $metainfo && is_object($metainfo) ){
                        if( $userinfo->status == 'active' ){
                            echo '<p class="login-box-msg">Your email address is already verified. You can use our website with this account.</p>';
                        }else{
                            echo '<p class="login-box-msg">Your email address is verified. Now, You can use our website with this account.</p>';
                        }

                        echo sprintf('<div class="col-12"><a href="%s" class="btn btn-primary btn-block">Back</a></div>', get_site_url());
                    }else{
                        echo '<p class="login-box-msg">Your Email verification <strong>authentication code</strong> is invalid. Please try
                            requesting new reset email verification link.</p>';

                        echo sprintf('<div class="col-12"><a href="%s" class="btn btn-primary btn-block">Back</a></div>', get_site_url());
                    }
                ?>
            </div>
        </div>
    </div>
</div>