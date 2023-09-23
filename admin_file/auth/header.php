<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo @$active['title']; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo get_admin_url_path(); ?>assets/modules/lineawesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/icheck-bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/adminlte.min.css"); ?>?v=2.3">
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/modules/alert/toastStyle.min.css"); ?>">

    <?php $version = filemtime(get_admin_path("assets/css/main.css", true)); ?>
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/main.css?ver=$version"); ?>" />
    
    <?php $version = filemtime(get_admin_path("assets/css/auth.css", true)); ?>
    <link rel="stylesheet" href="<?php echo get_admin_url_path("assets/css/auth.css?ver=$version"); ?>" />

    <?php do_action("ast_auth_header"); ?>
</head>

<body class="login-page">