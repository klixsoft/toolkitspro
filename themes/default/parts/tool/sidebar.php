<?php
/**
 * Hook Before popular tools
 */
do_action("ast/tool/sidebar/related/before", $tooldata);

if( $posttype == 'tool' ):
$toolcat = get_meta("tool", $tooldata->id, "category");
if( !empty( $toolcat ) && count( $toolcat ) > 0 ):
$tools = get_tools_by_category($toolcat[0]);
if( count( $tools ) > 1 ):
?>

<div class="card-box p-3 mb-4">
    <div class="card-title mb-1"><strong>Related Tools</strong></div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <?php
                foreach($tools as $key => $tool){
                    if( $tool->slug == $tooldata->slug ) continue;
                    echo sprintf('<li class="list-group-item"><a href="%s">%s</a></li>', get_tool_url("slug", $tool->slug), $tool->title);
                    if( $key > 10 ) break;
                }
            ?>
        </ul>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>


<?php

/**
 * Hook Before popular tools
 */
do_action("ast/tool/sidebar/popular/before", $tooldata);

$tools = get_popular_tools();
if( !empty( $tools ) && count( $tools ) > 0 ):
?>
<div class="card-box p-3">
    <div class="card-title mb-1"><strong>Popular Tools</strong></div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <?php 
                foreach($tools as $key => $tool){
                    echo sprintf('<li class="list-group-item"><a href="%s">%s</a></li>', get_tool_url("slug", $tool->slug), $tool->title);
                    if( $key > 10 ) break;
                }
            ?>
        </ul>
    </div>
</div>
<?php endif; ?>