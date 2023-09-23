<?php
$error404text = apply_filters("ast/404/page/btntext", "Go to Home Page");
$error404url = apply_filters("ast/404/page/btnlink", get_site_url());
$error404desc = apply_filters("ast/404/page/desc", "The page you are looking for might have been removed has it's name changed or temporarily unavailable.");
$error404title = apply_filters("ast/404/page/title", "Page Not Found");
?>

<style>
.wrapper-404error {
    display: flex;
    align-items: center;
    flex-direction: column;
}

.wrapper-404error h1 {
    font-size: 3rem;
    margin-top: 20px;
}

.wrapper-404error .message {
    font-size: 1.5rem;
    padding: 20px;
    width: 60%;
    text-align: center;
}

.wrapper-404error .btn {
    background: var(--primary);
    padding: 20px;
    font-size: 1.5rem;
    text-decoration: none;
    color: #fff;
}

.container_404wrapper svg {
    max-width: 500px;
    height: auto;
    margin: 1rem 0;
}
</style>

<div class="content-wrapper admin_dashboard_main_wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">404 Page</h1>
                </div>
                <div class="col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-white" href="http://allsmarttools.com/">Home</a></li>
                        <li class="breadcrumb-item active text-white">404 Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-center justify-content-center align-items-center d-flex">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="<?php echo get_site_url(); ?>" target="_blank" class="h1">
                        <?php echo get_site_logo_html(); ?>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <p class="login-box-msg">The page you are looking for might have been removed has it's name changed or temporarily unavailable.</p>
                        <div class="col-12"><a href="<?php echo get_site_url("admin/"); ?>"
                                class="btn btn-primary btn-block">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>