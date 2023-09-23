<div class="col-md-12">
    <div class="card bg-white p-3">
        <div class="alert alert-warning">
            <strong>Note: </strong> Error Log includes warnings, fatal errors and notice messages.
        </div>
        <div class="form-group">
            <textarea rows="20" class="form-control" disabled placeholder="Cron Log is Empty">
                <?php
                    $cronfile = ASTROOTPATH . "log/error.log";
                    if( file_exists( $cronfile ) )
                        echo file_get_contents($cronfile);
                ?>
            </textarea>
        </div>
    </div>
</div>