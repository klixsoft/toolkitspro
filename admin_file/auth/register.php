<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo get_site_url(); ?>" target="_blank" class="h1"><b>AllSmart</b>Tools</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>

            <?php do_action("tkp_before_register_form"); ?>

            <form action="<?php echo get_site_url("auth/register/"); ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="las la-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>

                    <div class="col-12">
                        <p class="mt-3 mb-0 text-center">Already Have an Account? <a href="<?php echo get_site_url("auth/login/"); ?>">Login From Here</a></p>
                    </div>
                </div>
            </form>

            <?php do_action("tkp_after_register_form"); ?>
        </div>

    </div>
</div>