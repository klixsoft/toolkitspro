<div class="col-md-4">
    <div class="card" data-id="<?php echo strtolower($label); ?>">
        <div class="card-header">
            <div class="form-group mb-0">
                <label>Column <?php echo ucfirst($label); ?></label>
                <input type="text" placeholder="Title" name="title" value="<?php echo @$settings['title']; ?>" class="form-control">
            </div>

            <select name="type" class="form-control">
                <?php
                    foreach($this->types as $k => $v){
                        $selected = $k == $type ? "selected" : "";
                        echo sprintf('<option value="%s" %s>%s</option>', $k, $selected, $v);
                    }
                ?>
            </select>
        </div>
        <div class="card-body">
            <?php
                if( $type == 'text' ){
                    include APP_PATH . "templates/columns/text.php";
                }else if( $type == 'populartools' || $type == 'latesttools' || $type == 'popularposts' || $type == 'latestposts' ){
                    include APP_PATH . "templates/columns/count.php";
                }else if( $type == 'menu' ){
                    include APP_PATH . "templates/columns/menu.php";
                }
            ?>
        </div>
    </div>
</div>