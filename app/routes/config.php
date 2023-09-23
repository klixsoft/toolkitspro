<?php 

return array(
    "admin" => array(
        "dashboard" => array(
            "title" => "Dashboard",
            "link" => "",
            "path" => "dashboard",
            "icon" => "las la-tachometer-alt",
            "child" => array()
        ),
        "analytics" => array(
            "title" => "Analytics",
            "link" => "analytics/",
            "icon" => "las la-chart-bar",
            "child" => array(
                "overview" => array(
                    "link" => "analytics/",
                    "path" => "analytics/index.php",
                    "title" => "Overview"
                ),
                "visitor-log" => array(
                    "link" => "analytics/visitor-log/",
                    "path" => "analytics/visitor-log.php",
                    "title" => "Visitor Log"
                ),
                "history" => array(
                    "link" => "analytics/history/",
                    "path" => "analytics/history.php",
                    "title" => "Recent History"
                ),
                "online" => array(
                    "link" => "analytics/online/",
                    "path" => "analytics/online.php",
                    "title" => "Online Users"
                )
            )
        ),
        "content_header" => array(
            "header" => "Content"
        ),
        "post" => array(
            "title" => "Posts",
            "link" => "post/",
            "icon" => "las la-newspaper",
            "child" => array(
                "add" => array(
                    "link" => "post/add/",
                    "path" => "post/add.php",
                    "title" => "Add New"
                ),
                "manage" => array(
                    "link" => "post/",
                    "path" => "post/index.php",
                    "title" => "Manage Posts"
                ),
                "category" => array(
                    "link" => "post/category/",
                    "path" => "post/category.php",
                    "title" => "Post Category"
                ),
                "edit" => array(
                    "link" => "post/edit/(.*)/",
                    "path" => "post/edit.php",
                    "title" => "Edit Post",
                    "hidden" => true
                ),
                "editcat" => array(
                    "link" => "post/category/edit/(.*)/",
                    "path" => "post/category.php",
                    "title" => "Edit Category",
                    "hidden" => true
                )
            )
        ),
        "page" => array(
            "title" => "Pages",
            "link" => "page/",
            "icon" => "las la-file-alt",
            "child" => array(
                "add" => array(
                    "link" => "page/add/",
                    "path" => "page/add.php",
                    "title" => "Add New Page"
                ),
                "edit" => array(
                    "link" => "page/edit/(.*)/",
                    "path" => "page/edit.php",
                    "title" => "Edit Page",
                    "hidden" => true
                ),
                "manage" => array(
                    "link" => "page/",
                    "path" => "page/index.php",
                    "title" => "Manage Pages"
                )
            )
        ),
        "comments" => array(
            "title" => "Comments",
            "link" => "comments/",
            "path" => "comments.php",
            "icon" => "las la-comments",
            "child" => array()
        ),
        "media" => array(
            "title" => "Media",
            "link" => "media/",
            "path" => "media.php",
            "icon" => "las la-images",
            "child" => array()
        ),
        "appearance_header" => array(
            "header" => "Appearance"
        ),
        "interface" => array(
            "title" => "Interface",
            "link" => "interface/",
            "icon" => "las la-globe",
            "child" => array(
                "themes" => array(
                    "link" => "interface/",
                    "path" => "interface/index.php",
                    "title" => "Themes"
                ),
                "colors" => array(
                    "link" => "interface/colors/",
                    "path" => "interface/colors.php",
                    "title" => "Colors"
                ),
                "menus" => array(
                    "link" => "interface/menus/",
                    "path" => "interface/menus.php",
                    "title" => "Menus"
                ),
                "footermenus" => array(
                    "link" => "interface/footermenus/",
                    "path" => "interface/footermenus.php",
                    "title" => "Footer Columns"
                )
            )
        ),
        "tool" => array(
            "title" => "Manage Tools",
            "icon" => "las la-tools",
            "link" => "tool/",
            "child" => array(
                "view" => array(
                    "link" => "tool/",
                    "path" => "tool/index.php",
                    "title" => "Active Tools"
                ),
                "upload" => array(
                    "link" => "tool/add/",
                    "path" => "tool/add.php",
                    "title" => "Upload Tools"
                ),
                "category" => array(
                    "link" => "tool/category/",
                    "path" => "tool/category.php",
                    "title" => "Category"
                ),
                "toolupdate" => array(
                    "link" => "tool/setting/(.*)/",
                    "path" => "tool/settings.php",
                    "title" => "Tool Settings",
                    "menu" => false
                ),
                "tooledit" => array(
                    "link" => "tool/edit/(.*)/",
                    "path" => "tool/edit.php",
                    "title" => "Edit Tool Settings",
                    "menu" => false
                )
            )
        ),
        "user" => array(
            "title" => "Users",
            "link" => "user/",
            "icon" => "las la-users",
            "child" => array(
                "add" => array(
                    "link" => "user/add/",
                    "path" => "user/add.php",
                    "title" => "Add User"
                ),
                "edit" => array(
                    "link" => "user/edit/(.*)/",
                    "path" => "user/edit.php",
                    "title" => "Edit User",
                    "hidden" => true
                ),
                "manage" => array(
                    "link" => "user/",
                    "path" => "user/index.php",
                    "title" => "Manage Users"
                ),
                "profile" => array(
                    "link" => "user/profile/",
                    "path" => "user/profile.php",
                    "title" => "Profile"
                )
            )
        ),
        "settings_header" => array(
            "header" => "Advance"
        ),
        "mail" => array(
            "title" => "Mail",
            "link" => "mail/",
            "icon" => "las la-envelope",
            "child" => array(
                "mail" => array(
                    "link" => "mail/",
                    "path" => "mail/index.php",
                    "title" => "Send Mail"
                ),
                "template" => array(
                    "link" => "mail/template/",
                    "path" => "mail/template.php",
                    "title" => "Templates"
                ),
                "settings" => array(
                    "link" => "mail/settings/",
                    "path" => "mail/settings.php",
                    "title" => "Settings"
                )
            )
        ),
        "plugins" => array(
            "title" => "Plugins",
            "link" => "plugins/",
            "path" => "plugins.php",
            "icon" => "las la-plug",
            "child" => array()
        ),
        "plans" => array(
            "title" => "Plans",
            "link" => "plan/",
            "icon" => "las la-th-large",
            "child" => array(
                "plan" => array(
                    "link" => "plan/",
                    "path" => "plan/index.php",
                    "title" => "Plans"
                ),
                "payments" => array(
                    "link" => "plan/payments/",
                    "path" => "plan/payments.php",
                    "title" => "Payments"
                ),
                "settings" => array(
                    "link" => "plan/settings/",
                    "path" => "plan/settings.php",
                    "title" => "Settings"
                ),
                "add" => array(
                    "link" => "plan/add/",
                    "path" => "plan/add.php",
                    "title" => "Add New"
                ),
                "edit" => array(
                    "link" => "plan/edit/(.*)/",
                    "path" => "plan/edit.php",
                    "title" => "Edit Plan"
                )
            )
        ),
        "apikeys" => array(
            "title" => "API Keys",
            "link" => "api-keys/",
            "path" => "apikeys.php",
            "icon" => "las la-key",
            "child" => array()
        ),
        "sitemap" => array(
            "title" => "Sitemap",
            "link" => "sitemap/",
            "path" => "sitemap.php",
            "icon" => "las la-sitemap",
            "child" => array()
        ),
        "setting" => array(
            "title" => "Site Settings",
            "icon" => "las la-cog",
            "link" => "setting/",
            "child" => array(
                "basic" => array(
                    "link" => "setting/",
                    "path" => "setting/index.php",
                    "title" => "Basic"
                ),
                "permalink" => array(
                    "link" => "setting/permalink/",
                    "path" => "setting/permalink.php",
                    "title" => "Permalink"
                ),
                "sitemap" => array(
                    "link" => "setting/sitemap/",
                    "path" => "setting/sitemap.php",
                    "title" => "Sitemap"
                ),
                "download" => array(
                    "link" => "setting/download/",
                    "path" => "setting/download.php",
                    "title" => "Download"
                ),
                "maintenance" => array(
                    "link" => "setting/maintenance/",
                    "path" => "setting/maintenance.php",
                    "title" => "Maintenance"
                )
            )
        ),
        "advance" => array(
            "title" => "Advance",
            "link" => "advance/",
            "icon" => "las la-snowflake",
            "child" => array(
                "cron" => array(
                    "link" => "advance/cron/",
                    "path" => "advance/cron.php",
                    "title" => "Cron Job"
                ),
                "minification" => array(
                    "link" => "advance/minification/",
                    "path" => "advance/minification.php",
                    "title" => "Minification"
                ),
                "robots" => array(
                    "link" => "advance/robots/",
                    "path" => "advance/robots.php",
                    "title" => "Robots.txt"
                ),
                "error" => array(
                    "link" => "advance/error/",
                    "path" => "advance/error.php",
                    "title" => "Error Log"
                ),
                "php-info" => array(
                    "link" => "advance/php-info/",
                    "path" => "advance/php-info.php",
                    "title" => "PHP Information"
                )
            )
        ),
        "license" => array(
            "title" => "License",
            "link" => "license/",
            "path" => "license.php",
            "icon" => "las la-key",
            "child" => array()
        )
    ),
    "auth" => array(
        "login" => array(
            "title" => "Login",
            "link" => "auth/login/",
            "path" => "auth/login.php"
        ),
        "register" => array(
            "title" => "Register Account",
            "link" => "auth/register/",
            "path" => "auth/register.php"
        ),
        "forget" => array(
            "title" => "Forget Password",
            "link" => "auth/forget-password/",
            "path" => "auth/forget-password.php"
        ),
        "recover-password" => array(
            "title" => "Recover Password",
            "link" => "auth/recover-password/",
            "path" => "auth/recover-password.php"
        ),
        "reset-password" => array(
            "title" => "Set Your New Password",
            "link" => "auth/change/reset-password/(.*)/",
            "path" => "auth/reset-password.php"
        ),
        "email-verification" => array(
            "title" => "Verify Your Email Address",
            "link" => "auth/change/verify-email/(.*)/",
            "path" => "auth/email-verification.php"
        )
    ),
    "front" => array(
        "tool" => array(
            "title" => "Tool",
            "link" => "tool/(.*)/",
            "path" => "single-tool.php",
            "page" => "tool"
        )
    ),
    "install" => array(
        "install" => array(
            "title" => "Install Script",
            "link" => "install/",
            "path" => "install.php"
        )
    )
);