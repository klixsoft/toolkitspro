<?php
global $router;
$paths = $router->get_params();
?>

<div class="col-12">
    <form action="">
        <div class="row">
            <div class="col-md-9">
                <div class="card bg-white p-3">
                    <?php 

                    ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-white p-3">
                    <input type="text" name="tool" class="d-none" value="<?php echo $paths[3]; ?>">
                    <input type="text" name="action" class="d-none" value="update_tool_settings">
                    <button class="btn btn-primary btn-block updatetoolsettings" type="submit">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>