<?php
$robotFile = ASTROOTPATH . "robots.txt";
if( ! file_exists( $robotFile ) ){
    \AST\FileSystem::create($robotFile);
}
?>

<div class="col-md-12">
    <div class="card bg-white p-3">
        <div class="form-group mt-3">
            <label>Robots.txt Content</label>
            <em class="d-block my-1">You can view your robots.txt file in: <a href="<?php echo get_site_url("robots.txt"); ?>" target="_blank" rel="noopener noreferrer"><?php echo get_site_url("robots.txt"); ?></a></em>
            <textarea rows="10" class="form-control robotsContent" placeholder="Robots.txt is Empty"><?php echo file_get_contents($robotFile); ?></textarea>
        </div>

        <div class="button-group w-100 text-center">
            <button class="btn btn-primary updateRobots" type="button">Update Robots.txt</button>
        </div>
    </div>
</div>