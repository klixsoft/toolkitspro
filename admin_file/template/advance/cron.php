<?php
$cronfile = ASTROOTPATH . "app/temp/log/cron.log";

$cronlog = "";
if( file_exists( $cronfile ) )
    $cronlog = file_get_contents($cronfile);
?>

<div class="col-md-12">
    <div class="card bg-white p-3">
        <div class="form-group">
            <label>Cron Job Path</label>
            <input type="text" value="0 */6 * * * wget -O /dev/null <?php echo get_site_url("cron.php"); ?>" disabled class="form-control">
        </div>

        <div class="form-group mt-3">
            <label>Cron Log</label>
            <textarea rows="10" class="form-control" disabled placeholder="Cron Log is Empty"><?php echo $cronlog; ?></textarea>
        </div>
    </div>
</div>