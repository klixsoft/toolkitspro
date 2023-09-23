<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - ToolKitsPRO</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="https://toolkitspro.com/app/uploads/favicon.ico" type="image/x-icon">
    <link rel="alternate icon" href="https://toolkitspro.com/app/uploads/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>

    <link rel="stylesheet" href="<?php echo get_site_url("admin_file/assets/modules/alert/toastStyle.min.css"); ?>">
    
    <?php $version = filemtime(get_site_path() . "admin_file/install/css/style.css"); ?>
    <link rel="stylesheet" href="<?php echo get_site_url("admin_file/install/css/style.css?v=$version") ?>">
</head>

<body>
    <section class="multi_step_form">
        <form id="msform" method="post">
            <!-- Tittle -->
            <div class="tittle">
                <h2 class="mb-0">ToolKitsPRO Installation</h2>
                <p class="mb-0">In order to setup toolkitspro, you have to complete this installation process</p>
            </div>
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active home tab">Home</li>
                <li class="requirement tab">Requirements</li>
                <li class="database tab">Database</li>
                <li class="admin tab">Admin</li>
                <li class="complete tab">Complete</li>
            </ul>

            <!-- fieldsets -->
            <div class="fieldsets_container position-relative py-3">
                <fieldset></fieldset>
                <div class="spinner_container"><div class="spinner"></div></div>
            </div>
            <br />
            <br />

            <input type="text" class="d-none" name="siteurl" value="<?php echo get_site_url(); ?>">
            <input type="text" class="d-none" name="sitepath" value="<?php echo get_site_path_only(); ?>">
            <input type="text" class="d-none" name="action" value="get_installation_step">
            <input type="text" class="d-none currentPage" name="page" value="home">
            <input type="text" class="d-none pageType" name="type" value="next">
            <input type="text" class="d-none" name="install" value="installation">
        </form>
    </section>

    <script>const tookitspro = <?php echo json_encode(array(
        "ajaxurl" => get_site_url("ajax.php")
    )); ?></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
    
    <script src="<?php echo get_site_url("admin_file/assets/modules/alert/toast.min.js"); ?>"></script>
    <?php $version = filemtime(get_site_path() . "admin_file/install/js/script.js"); ?>
    <script src="<?php echo get_site_url("admin_file/install/js/script.js?v=$version") ?>"></script>
</body>

</html>