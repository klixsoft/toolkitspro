<?php
$user = get_user();
?>

<div class="beadcrum textture_background py-2">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-0">Profile</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
.profile_container .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid transparent;
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}

.list-group-item h6 {
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-group-item h6 i {
    font-size: 1.5rem;
    margin-right: 5px;
}

body .accountmenus .nav-link{
    padding: 15px 20px;
    border-bottom: 1px solid #ddd;
    border-radius: 0;
    color: #333;
}

body .accountmenus .nav-link.active{
    background: var(--primary);
    border-radius: 0;
}

body .accountmenus .nav-link:not(.active):hover{
    background: rgb(var(--primaryrgb), 0.1);
    border-radius: 0;
}
</style>
<div class="container profile_container my-5">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column align-items-center text-center p-3">
                            <img src="<?php echo get_avatar_url(); ?>" alt="Profile Image"
                                class="rounded-circle p-1 bg-primary" width="100">
                            <div class="mt-2">
                                <h5 class="mb-0"><?php echo $user->name; ?></h5>
                                <p class="text-muted font-size-sm"><?php echo $user->email; ?></p>
                            </div>
                        </div>
                        <div class="accountmenus nav flex-column nav-pills">
                            <?php
                                $accountkeys = get_account_menus();
                                foreach($accountkeys as $key => $menu){
                                    $url = get_account_url();
                                    if( $key != "account" ){
                                        $url .= $key . "/";
                                    }

                                    $active = $accountkey == $key ? "active" : "";
                                    echo sprintf('<a class="nav-link %s" href="%s"> <i class="%s text-center me-1"></i>%s</a>', $active, $url, $menu['icon'], $menu['title']);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <?php
                    $accountpath = get_theme_path() . "parts/account/$accountkey.php";
                    if( file_exists( $accountpath ) ){
                        include $accountpath;
                    }else if(has_action("tkp/account/menu/content")){
                        do_action("tkp/account/menu/content", $accountkey);
                    }else{
                        include get_theme_path() . "parts/account/notfound.php";
                    }
                ?>
            </div>
        </div>
    </div>
</div>