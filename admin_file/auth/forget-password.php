<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo get_site_url(); ?>" target="_blank" class="h1">
                <?php echo get_site_logo_html(); ?>
            </a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <form action="<?php echo get_site_url("auth/forget-password/"); ?>" method="post" class="ast_login_form">
                <div class="input-group mb-3">
                    <input type="email" required data-alert="Please provide valid email address!!!" class="form-control" name="userid" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="action" value="send_user_reset_password_link" style="display:none;">
                        <input type="text" name="redirect_url" value="<?php echo get_redirect_path_from_url(); ?>" style="display:none;">
                        <button type="submit" data-type="resetpassword" class="btn btn-primary btn-block loginbtn">Request Reset Link</button>
                    </div>

                </div>
            </form>
            <p class="mt-3 mb-1">
                Rembered the Password. <a href="<?php echo get_site_url("auth/login/"); ?>">Login from here</a>
            </p>
        </div>
    </div>
</div>