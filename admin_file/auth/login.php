<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo get_site_url(); ?>" target="_blank" class="h1">
                <?php echo get_site_logo_html(); ?>
            </a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php do_action("tkp_before_login_form"); ?>

            <form action="<?php echo get_site_url("auth/login/"); ?>" method="post" class="ast_login_form">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" required name="username" placeholder="Email/Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" required name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div class="mb-0"><a href="<?php echo get_site_url("auth/forget-password/"); ?>?redirect_url=<?php echo get_redirect_url(); ?>">Forget Password</a></div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="text" name="action" value="ast_login" style="display:none;">
                        <input type="text" name="redirect_url" value="<?php echo get_redirect_path_from_url(); ?>" style="display:none;">
                        <button type="submit" data-type="login" class="btn btn-primary btn-block loginbtn">Sign In</button>
                    </div>

                    <div class="col-12">
                        <p class="mt-3 mb-0 text-center">Don't Have an Account? <a href="<?php echo get_site_url("auth/register/"); ?>?redirect_url=<?php echo get_redirect_url(); ?>">Register from here</a></p>
                    </div>
                </div>
            </form>

            <?php do_action("tkp_after_login_form"); ?>
        </div>

    </div>

</div>