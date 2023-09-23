<div class="col text-left p-0 mt-4" id="related_tools_list">
    <div class="heading d-inline-block text-white">Try Other Relevant Tools</div>
    <div class="tools_lists">
        <?php 
            foreach($tools as $tool){
                if( $activeTool == $tool->id ) continue;
                echo sprintf('<a href="%s" class="text-decoration-none m-1 d-inline-block">%s</a>', get_tool_url("slug", $tool->slug), $tool->title);
            }
        ?>
    </div>
</div>