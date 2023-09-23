<style>
.card table tr td:nth-child(1){
    width:80%;
}

.card table tr td:nth-child(2){
    width:20%;
}
</style>

<div class="card">
    <div class="card-header"><strong>Requirements</strong></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <td>Extension/Application</td>
                    <td>Status</td>
                </tr>
            </thead>

            <tbody>
                <?php 
                    $installation = Installation::check_requirement();
                ?>
                <tr>
                    <td>PHP Version</td>
                    <td>
                        <?php 
                            if( $installation->requirements->version ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Require PHP > 8.0.0", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>MYSQLI Extension</td>
                    <td>
                        <?php 
                            if( $installation->requirements->mysqli ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>file_get_contents()</td>
                    <td>
                        <?php 
                            if( $installation->requirements->file_get_contents ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>PDO Extension</td>
                    <td>
                        <?php 
                            if( $installation->requirements->pdo ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>WHOIS Port 43</td>
                    <td>
                        <?php 
                            if( $installation->requirements->whoisport ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>GD Extension</td>
                    <td>
                        <?php 
                            if( $installation->requirements->gd ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>CURL Extension</td>
                    <td>
                        <?php 
                            if( $installation->requirements->curl ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>XML/DOM Extension</td>
                    <td>
                        <?php 
                            if( $installation->requirements->xml ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Imagick Class</td>
                    <td>
                        <?php 
                            if( $installation->requirements->imagick ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>exec/shell_exec Functions</td>
                    <td>
                        <?php 
                            if( $installation->requirements->exec ){
                                Installation::badge("Available");
                            }else{
                                Installation::badge("Not Available", "danger");
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><strong>Directory & Permission</strong></div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <td>Directory</td>
                    <td>Status</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Configuration File ("./config.php")</td>
                    <td>
                        <?php 
                            if( $installation->files->config ){
                                Installation::badge("Writable");
                            }else{
                                Installation::badge("Not Writable", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Upload Directory ("./app/uploads/")</td>
                    <td>
                        <?php 
                            if( $installation->files->uploads ){
                                Installation::badge("Writable");
                            }else{
                                Installation::badge("Not Writable", "danger");
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Temp Directory ("./app/temp/")</td>
                    <td>
                        <?php 
                            if( $installation->files->temp ){
                                Installation::badge("Writable");
                            }else{
                                Installation::badge("Not Writable", "danger");
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php if($installation->allcheck): ?>
<div class="button-row mt-4">
    <button type="button" data-current="<?php echo Installation::current(); ?>" data-prev="<?php echo Installation::prev(); ?>" class="action-button previous_button">Back</button>
    <button type="button" data-next="<?php echo Installation::next(); ?>" class="proceedBtn action-button">Continue</button>
</div>
<?php endif; ?>