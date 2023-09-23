<?php
global $router;
global $db;
$params = $router->get_params();

$userID = false;
if( isset( $params[2] ) && !empty($params[2]) ){
    $db->where("meta_key", "user_reset_password_key");
    $db->where("meta_value", $params[2]);
    $results = $db->get("meta_data", 1);
    if( !empty( $results ) && is_array($results) && count($results) > 0 ){
        $userID = $results[0]->meta_id;
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

            <?php if($userID): ?>
            <p class="login-box-msg">Please provide strong password including characters, number and special character.
            </p>
            <form action="<?php echo get_site_url("auth/forget-password/"); ?>" method="post" class="ast_login_form">
                <div class="input-group mb-3">
                    <input type="password" required data-alert="Please provide new password!!!" class="form-control"
                        name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" required data-alert="Please provide confirm password!!!" class="form-control"
                        name="cpassword" placeholder="Confirm Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-lock"></span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <input type="text" name="action" value="authcode_reset_password" style="display:none;">
                        <input type="text" name="authcode" value="<?php echo $params[2]; ?>" style="display:none;">
                        <button type="submit" data-type="resetpassword"
                            class="btn btn-primary btn-block loginbtn">Change Password</button>
                    </div>
                </div>
            </form>
            <?php else: ?>
            <p class="login-box-msg">Your reset password <strong>authentication code</strong> is invalid. Please try
                requesting new reset password link.</p>

            <div class="row">
                <div class="col-12">
                    <a href="<?php echo get_site_url("auth/forget-password/"); ?>" class="btn btn-primary btn-block">Request New Link</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>