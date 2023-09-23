<ul class="flex-column nav">
    <?php
        foreach($menus as $menu){
            echo sprintf('<li class="nav-item"><a class="nav-link ps-0" href="%s">%s</a></li>', $menu['link'], $menu['title']);
        }
    ?>
</ul>