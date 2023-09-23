<ul class="flex-column nav">
    <?php
        foreach($posts as $post){
            $link = "#";
            if( $post->type == 'tool' ){
                $link = get_tool_url("slug", $post->slug);
            }else if( $post->type == 'post' ){
                $link = get_post_url("slug", $post->slug);
            }
            
            echo sprintf('<li class="nav-item"><a class="nav-link ps-0" href="%s">%s</a></li>', $link, $post->title);
        }
    ?>
</ul>