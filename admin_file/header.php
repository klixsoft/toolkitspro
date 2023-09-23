<?php $user = get_user(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo get_admin_url_path(); ?>assets/modules/lineawesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/icheck-bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/fancybox/jquery.fancybox-1.3.4.css"); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/adminlte.min.css"); ?>?v=2.7" />
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/datatable/datatables.min.css?v=1.13.1"); ?>" />
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/datatable/datatable-bootstrap/css/dataTables.bootstrap4.min.css?v=1.13.1"); ?>" />
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/alert/toastStyle.min.css?v=1.0"); ?>">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/alertifyjs/css/alertify.css?v=3.1.0"); ?>">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/iziToast/dist/css/iziToast.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/colorpicker/jquery.minicolors.css"); ?>">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/tagify/dist/tagin.min.css"); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    
    <?php $version = filemtime(get_admin_path("assets/css/main.css", true)); ?>
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/main.css?ver=$version"); ?>" />
    <?php
        /**
         * Include any code to admin header
         */
        do_action("admin_header");
    ?>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">

    <?php
        
        /************************************
         *  AFTER IMMEDIATE BODY TAG OPEN
         ***********************************/
        do_action("ast/admin/after/body");
        
    ?>

    <div class="wrapper">

        <nav class="main-header navbar navbar-expand elevation-2 navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="las la-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo get_site_url(); ?>" target="_blank" class="nav-link">Visit Website</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://product.toolkitspro.com/support/" target="_blank" class="nav-link">Support</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://product.toolkitspro.com/docs/" target="_blank" class="nav-link">Documentation</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="las la-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="las la-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="las la-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="las la-user"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar elevation-1 sidebar-light-danger">
            <a href="<?php echo get_admin_url(); ?>" class="brand-link text-center">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 807 144"
                    version="1.1" width="180px">
                    <g>
                        <path style=" stroke:none;fill-rule:evenodd;fill:var(--primary);fill-opacity:1;"
                            d="M 116.410156 57.230469 C 116.410156 121.351562 63.074219 140.230469 63.074219 140.230469 L 63.074219 110.363281 C 33.625 110.363281 9.742188 86.570312 9.742188 57.230469 C 9.742188 27.886719 33.625 4.097656 63.074219 4.097656 C 92.527344 4.097656 116.410156 27.886719 116.410156 57.230469 Z M 63.074219 74.621094 C 72.714844 74.621094 80.636719 66.828125 80.636719 57.230469 C 80.636719 47.519531 72.714844 39.730469 63.074219 39.730469 C 53.4375 39.730469 45.511719 47.519531 45.511719 57.230469 C 45.511719 66.828125 53.4375 74.621094 63.074219 74.621094 Z M 63.074219 74.621094 " />
                        <path
                            style="fill:#000;stroke-width:2;stroke-linecap:butt;stroke-linejoin:miter;stroke:#000;stroke-opacity:1;stroke-miterlimit:4;"
                            d="M 249.898699 52.177083 L 249.898699 70.697917 C 245.086939 68.546875 240.395083 66.927083 235.82313 65.84375 C 231.261603 64.75 226.950308 64.197917 222.894459 64.197917 C 217.498824 64.197917 213.510746 64.942708 210.925012 66.427083 C 208.349704 67.901042 207.067263 70.197917 207.067263 73.322917 C 207.067263 75.671875 207.93265 77.505208 209.67385 78.822917 C 211.409837 80.130208 214.563807 81.25 219.140974 82.177083 L 228.754066 84.114583 C 238.471422 86.072917 245.378877 89.046875 249.481645 93.03125 C 253.5792 97.005208 255.63319 102.666667 255.63319 110.010417 C 255.63319 119.666667 252.765944 126.84375 247.04188 131.552083 C 241.328241 136.260417 232.590962 138.614583 220.830042 138.614583 C 215.283225 138.614583 209.715555 138.083333 204.127033 137.03125 C 198.538511 135.979167 192.955202 134.416667 187.382319 132.34375 L 187.382319 113.302083 C 192.955202 116.260417 198.350836 118.5 203.56401 120.010417 C 208.78761 121.510417 213.823536 122.260417 218.661362 122.260417 C 223.582598 122.260417 227.346509 121.442708 229.963522 119.802083 C 232.590962 118.166667 233.904682 115.817708 233.904682 112.760417 C 233.904682 110.026042 233.013229 107.921875 231.235537 106.447917 C 229.452631 104.963542 225.907673 103.630208 220.600662 102.447917 L 211.863383 100.510417 C 203.115677 98.635417 196.724326 95.651042 192.678903 91.552083 C 188.63348 87.458333 186.610769 81.927083 186.610769 74.96875 C 186.610769 66.260417 189.415457 59.567708 195.035258 54.885417 C 200.665486 50.192708 208.756331 47.84375 219.307795 47.84375 C 224.114341 47.84375 229.05643 48.208333 234.134061 48.927083 C 239.206479 49.651042 244.461359 50.734375 249.898699 52.177083 Z M 275.432824 49.427083 L 304.146985 49.427083 L 324.082162 96.239583 L 344.121602 49.427083 L 372.773205 49.427083 L 372.773205 136.90625 L 351.440898 136.90625 L 351.440898 72.927083 L 331.276342 120.09375 L 316.992246 120.09375 L 296.827689 72.927083 L 296.827689 136.90625 L 275.432824 136.90625 Z M 447.941958 120.96875 L 412.680051 120.96875 L 407.112381 136.90625 L 384.424649 136.90625 L 416.829737 49.427083 L 443.729714 49.427083 L 476.134802 136.90625 L 453.44707 136.90625 Z M 418.289426 104.739583 L 442.270025 104.739583 L 430.300578 69.927083 Z M 519.769067 88.21875 C 524.492202 88.21875 527.880765 87.34375 529.924329 85.59375 C 531.97832 83.833333 533.010528 80.9375 533.010528 76.90625 C 533.010528 72.921875 531.97832 70.072917 529.924329 68.364583 C 527.880765 66.645833 524.492202 65.78125 519.769067 65.78125 L 510.28109 65.78125 L 510.28109 88.21875 Z M 510.28109 103.802083 L 510.28109 136.90625 L 487.718474 136.90625 L 487.718474 49.427083 L 522.187979 49.427083 C 533.709093 49.427083 542.154435 51.364583 547.524004 55.239583 C 552.88836 59.104167 555.573144 65.213542 555.573144 73.572917 C 555.573144 79.354167 554.176014 84.09375 551.381752 87.802083 C 548.597918 91.510417 544.3961 94.25 538.765872 96.010417 C 541.852071 96.708333 544.60984 98.296875 547.044392 100.78125 C 549.48937 103.270833 551.965628 107.026042 554.467951 112.052083 L 566.708483 136.90625 L 542.686179 136.90625 L 532.030451 115.177083 C 529.872197 110.802083 527.693091 107.817708 525.482705 106.21875 C 523.282746 104.609375 520.342516 103.802083 516.662015 103.802083 Z M 564.30521 49.427083 L 644.942582 49.427083 L 644.942582 66.46875 L 615.936484 66.46875 L 615.936484 136.90625 L 593.373867 136.90625 L 593.373867 66.46875 L 564.30521 66.46875 Z M 177.998606 25.520833 "
                            transform="matrix(0.749304,0,0,0.75,0,0)" />
                        <path
                            style="fill:var(--primary);stroke-width:2;stroke-linecap:butt;stroke-linejoin:miter;stroke:var(--primary);stroke-opacity:1;stroke-miterlimit:4;"
                            d="M 633.583077 49.520833 L 714.220449 49.520833 L 714.220449 66.5625 L 685.21435 66.5625 L 685.21435 137 L 662.651734 137 L 662.651734 66.5625 L 633.583077 66.5625 Z M 765.841296 64.291667 C 758.959906 64.291667 753.621617 66.833333 749.826426 71.916667 C 746.041662 76.989583 744.154493 84.135417 744.154493 93.354167 C 744.154493 102.536458 746.041662 109.666667 749.826426 114.75 C 753.621617 119.822917 758.959906 122.354167 765.841296 122.354167 C 772.748751 122.354167 778.092254 119.822917 781.877018 114.75 C 785.672209 109.666667 787.569804 102.536458 787.569804 93.354167 C 787.569804 84.135417 785.672209 76.989583 781.877018 71.916667 C 778.092254 66.833333 772.748751 64.291667 765.841296 64.291667 Z M 765.841296 47.9375 C 779.896012 47.9375 790.906235 51.96875 798.871965 60.020833 C 806.848121 68.0625 810.841412 79.177083 810.841412 93.354167 C 810.841412 107.494792 806.848121 118.59375 798.871965 126.645833 C 790.906235 134.6875 779.896012 138.708333 765.841296 138.708333 C 751.812645 138.708333 740.802422 134.6875 732.810627 126.645833 C 724.829258 118.59375 720.84118 107.494792 720.84118 93.354167 C 720.84118 79.177083 724.829258 68.0625 732.810627 60.020833 C 740.802422 51.96875 751.812645 47.9375 765.841296 47.9375 Z M 867.852681 64.291667 C 860.971291 64.291667 855.633001 66.833333 851.837811 71.916667 C 848.053047 76.989583 846.165878 84.135417 846.165878 93.354167 C 846.165878 102.536458 848.053047 109.666667 851.837811 114.75 C 855.633001 119.822917 860.971291 122.354167 867.852681 122.354167 C 874.760136 122.354167 880.103639 119.822917 883.888403 114.75 C 887.683594 109.666667 889.581189 102.536458 889.581189 93.354167 C 889.581189 84.135417 887.683594 76.989583 883.888403 71.916667 C 880.103639 66.833333 874.760136 64.291667 867.852681 64.291667 Z M 867.852681 47.9375 C 881.907397 47.9375 892.91762 51.96875 900.88335 60.020833 C 908.859506 68.0625 912.852797 79.177083 912.852797 93.354167 C 912.852797 107.494792 908.859506 118.59375 900.88335 126.645833 C 892.91762 134.6875 881.907397 138.708333 867.852681 138.708333 C 853.82403 138.708333 842.813807 134.6875 834.822012 126.645833 C 826.840642 118.59375 822.852564 107.494792 822.852564 93.354167 C 822.852564 79.177083 826.840642 68.0625 834.822012 60.020833 C 842.813807 51.96875 853.82403 47.9375 867.852681 47.9375 Z M 929.889449 49.520833 L 952.452065 49.520833 L 952.452065 119.958333 L 992.072186 119.958333 L 992.072186 137 L 929.889449 137 Z M 1067.240939 52.270833 L 1067.240939 70.791667 C 1062.429179 68.640625 1057.737323 67.020833 1053.165369 65.9375 C 1048.603842 64.84375 1044.292548 64.291667 1040.236698 64.291667 C 1034.841064 64.291667 1030.852986 65.036458 1028.267251 66.520833 C 1025.691944 67.994792 1024.409503 70.291667 1024.409503 73.416667 C 1024.409503 75.765625 1025.27489 77.598958 1027.01609 78.916667 C 1028.752077 80.223958 1031.906047 81.34375 1036.483213 82.270833 L 1046.096306 84.208333 C 1055.813662 86.166667 1062.721117 89.140625 1066.823885 93.125 C 1070.921439 97.098958 1072.97543 102.760417 1072.97543 110.104167 C 1072.97543 119.760417 1070.108184 126.9375 1064.384119 131.645833 C 1058.670481 136.354167 1049.933202 138.708333 1038.172282 138.708333 C 1032.625465 138.708333 1027.057795 138.177083 1021.469273 137.125 C 1015.88075 136.072917 1010.297441 134.510417 1004.724559 132.4375 L 1004.724559 113.395833 C 1010.297441 116.354167 1015.693076 118.59375 1020.90625 120.104167 C 1026.12985 121.604167 1031.165776 122.354167 1036.003601 122.354167 C 1040.924837 122.354167 1044.688749 121.536458 1047.305762 119.895833 C 1049.933202 118.260417 1051.246921 115.911458 1051.246921 112.854167 C 1051.246921 110.119792 1050.355469 108.015625 1048.577776 106.541667 C 1046.794871 105.057292 1043.249913 103.723958 1037.942902 102.541667 L 1029.205623 100.604167 C 1020.457917 98.729167 1014.066566 95.744792 1010.021143 91.645833 C 1005.97572 87.552083 1003.953009 82.020833 1003.953009 75.0625 C 1003.953009 66.354167 1006.757696 59.661458 1012.377498 54.979167 C 1018.007725 50.286458 1026.098571 47.9375 1036.650035 47.9375 C 1041.456581 47.9375 1046.39867 48.302083 1051.476301 49.020833 C 1056.548719 49.744792 1061.803598 50.828125 1067.240939 52.270833 Z M 632.999201 25.614583 "
                            transform="matrix(0.749304,0,0,0.75,0,0)" />
                    </g>
                </svg>
            </a>

            <div class="sidebar pb-5">
                <div class="form-inline mt-4">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="las la-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2 mb-4">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy mt-3" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <?php
                            global $routerLinks;
                            foreach( $routerLinks['admin'] as $key => $menu ){
                                if( ! isset( $menu['hidden'] ) ){
                                    if( isset( $menu['header'] ) ){
                                        echo sprintf('<li class="nav-header">%s</li>', strtoupper($menu['header']));
                                    }else{
                                        if(
                                            isset( $menu['child'] )
                                            && is_array( $menu['child'] )
                                            && !empty( $menu['child'] )
                                        ){
                                            echo '<li class="nav-item">';
                                            echo sprintf('<a href="#" class="nav-link">
                                                <i class="nav-icon %s"></i>
                                                <p>%s <i class="right las la-angle-left"></i></p>
                                            </a>', $menu['icon'], $menu['title']);
                                            echo '<ul class="nav nav-treeview">';
                                            
                                            foreach( $menu['child'] as $k => $m ){
                                                if( ! isset( $m['hidden'] ) ){
                                                    if( isset( $m['menu'] ) && !filter_var($m['menu'], FILTER_VALIDATE_BOOLEAN)) continue;
                                                    echo sprintf('<li class="nav-item">
                                                        <a href="%s" class="nav-link">
                                                            <i class="nav-icon las la-circle"></i>
                                                            <p>%s</p>
                                                        </a>
                                                    </li>', get_admin_url($m['link'], false), $m['title']);
                                                }
                                            }
        
                                            echo '</ul></li>';
                                        }else{
                                            if( isset( $menu['menu'] ) && !filter_var($menu['menu'], FILTER_VALIDATE_BOOLEAN)) continue;
                                            echo sprintf('<li class="nav-item">
                                                <a href="%s" class="nav-link">
                                                    <i class="nav-icon %s"></i>
                                                    <p>%s</p>
                                                </a>
                                            </li>', get_admin_url($menu['link'], false), $menu['icon'], $menu['title']);
                                        }
                                    }
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>

            <div class="sidebar-footer">
                <div class="py-2 pl-3 pr-0 d-flex align-items-center">
                    <a href="<?php echo get_site_url('admin/user/profile/'); ?>" class="d-flex align-items-center text-secondary text-decoration-none flex-grow-1">
                        <img src="<?php echo get_avatar_url(); ?>" class="flex-shrink-0 rounded-circle width-10 height-10 mr-3">

                        <div class="d-flex flex-column text-truncate">
                            <div class="fw-bold text-dark text-truncate">
                                <?php echo $user->name; ?>
                            </div>

                            <div class="small fw-bold">Account</div>
                        </div>
                    </a>

                    <a class="py-2 px-4 d-flex flex-shrink-0 align-items-center text-secondary" href="<?php echo get_logout_url("auth/login/"); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current width-4 height-4" viewBox="0 0 18 18"><path d="M7.09,12.59,8.5,14l5-5-5-5L7.09,5.41,9.67,8H0v2H9.67ZM16,0H2A2,2,0,0,0,0,2V6H2V2H16V16H2V12H0v4a2,2,0,0,0,2,2H16a2,2,0,0,0,2-2V2A2,2,0,0,0,16,0Z"/></svg>
                    </a>
                </div>
            </div>
        </aside>