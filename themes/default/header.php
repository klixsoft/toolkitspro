<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO META CONTENT -->
    <?php if( isset( $metainfo ) ){ echo $metainfo; } ?>
    <!-- SEO META CONTENT END -->

    <!-- HEADER CONTENT -->
    <?php do_action("ast_front_header"); ?>
    <!-- HEADER CONTENT END -->

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3914734187955412"
        crossorigin="anonymous"></script>
</head>

<body <?php echo get_body_class(); ?>>
    <?php
        
        /************************************
         *  AFTER IMMEDIATE BODY TAG OPEN
         ***********************************/
        do_action("ast/front/after/body");
        
    ?>
    <header class="navbar navbar-expand-lg navbar-light d-print-none py-2 py-md-1">
        <div class="container-xl">
            <button aria-label="Mobile Menu Toggle Button" class="navbar-toggler collapsed px-0" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a aria-label="Website Logo"
                class="navbar-brand text-decoration d-none-navbar-horizontal pe-0 pe-lg-3 m-auto"
                href="<?php echo get_site_url(); ?>">
                <?php echo get_site_logo_html(); ?>
            </a>

            <div class="navbar-nav flex-row order-lg-last m-lg-auto">
                <div class="nav-item me-2">
                    <a href="#" aria-label="Toolge Dark/Light Theme"
                        class="btn btn-icon btn-toggle-mode btn-toggle-theme">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="4"></circle>
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                            </path>
                        </svg>
                    </a>

                    <a aria-label="Search on Website" href="<?php echo get_site_url("search/"); ?>"
                        class="btn btn-icon btn-search">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                            <path fill="url(#gradientColor)"
                                d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z" />
                        </svg>
                    </a>
                </div>

                <!-- Begin::Navbar Right -->
                <?php if( is_user_loggin() ): ?>
                <div class="nav-item nav_right_btn">
                    <a class="btn me-2 btn-primary" href="<?php echo get_account_url(); ?>">
                        <i class="las la-user-alt icon"></i>
                        Account
                    </a>
                </div>

                <div class="nav-item nav_right_btn">
                    <a class="btn btn-outline-primary" href="<?php echo get_logout_url(true); ?>">
                        <i class="las la-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
                <?php else: ?>
                <div class="nav-item nav_right_btn">
                    <a class="btn me-2 btn-primary" href="<?php echo get_site_url("auth/register/"); ?>">
                        <i class="las la-user-alt icon"></i>
                        Register
                    </a>
                </div>

                <div class="nav-item nav_right_btn">
                    <a class="btn btn-outline-primary" href="<?php echo get_site_url("auth/login/"); ?>">
                        <i class="las la-sign-in-alt"></i>
                        Login
                    </a>
                </div>
                <?php endif; ?>

            </div>

            <div class="navbar-collapse collapse" id="navbar-menu" style="">
                <div
                    class="d-flex flex-column flex-lg-row flex-fill align-items-stretch align-items-lg-center justify-content-center">
                    <ul class="navbar-nav">

                        <?php
                            $menusSettings = (array) get_settings("menus");
                            render_menu_template_front($menusSettings); 
                        ?>
                    </ul>

                </div>
            </div>

            <div class="tkp__menu d-none">
                <nav class="tkp__menu-box">
                    <div class="close-btn"><i class="las la-times"></i></div>
                    <div class="nav-logo">
                        <a aria-label="Website Logo" href="<?php echo get_site_url(); ?>" class="logo-light">
                            <?php echo get_site_logo_html(); ?>
                        </a>
                    </div>
                    <div class="tkp__search">
                        <div>
                            <label id="MobileSearchInputLabel" for="MobileSearchInput" class="d-none">Search
                                tools</label>
                            <input type="text" id="MobileSearchInput" aria-labelledby="DesktopSearchInputLabel" disabled
                                placeholder="Search here...">
                            <button aria-label="Tool Search Button" type="button"><i class="la la-search"></i></button>
                        </div>
                    </div>
                    <div class="tkp__menu-outer">
                        <ul class="navigation">
                            <?php
                                render_menu_template_front_mobile($menusSettings); 
                            ?>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="tkp__menu-backdrop d-none"></div>

            <div class="navbar-search-container tools_section d-none">
                <form action="<?php echo get_site_url("search"); ?>" class="navbar-search position-relative px-3">
                    <div class="search-field">
                        <label id="DesktopSearchInputLabel" for="DesktopSearchInput" class="d-none">Search tools</label>
                        <input aria-labelledby="DesktopSearchInputLabel" id="DesktopSearchInput" type="text"
                            class="navbar-search-field searchtools" name="q" placeholder="Search Tools Here...">

                        <!-- <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div> -->

                        <button aria-label="Tool Search Button" class="navbar-search-btn" type="button"><i
                                class="las la-search"></i></button>
                    </div>
                    <a href="#" class="navbar-search-close" aria-label="Tool Search Close Button"><i
                            class="las la-times"></i></a>
                </form>

                <!-- <div style="display:none;" class="tkp_spinner tkp_spinner justify-content-center mt-3 mb-4 w-100">
                    <div class="spinner"></div>
                </div> -->

                <div class="row mt-4 g-1 px-lg-4 mb-5 toolslist">
                    <div class="tools w-100 px-3"></div>
                </div>
            </div>

        </div>
    </header>