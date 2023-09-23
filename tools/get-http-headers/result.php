
<style>
.headers_table tr td{
    word-wrap: break-word;
    word-break: break-all;
    white-space: normal;
}

.headers_table tr td:first-child {
    width: calc(100vw / 6);
}
</style>
<div class="table-responsive headers_table mt-3">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th class="p-3 text-center">HTTP Headers : <?php echo extractHostname($_POST['link']); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($result as $key => $value){
                    if( is_string( $value ) ){
                        echo sprintf('<tr><td>%s</td></tr>', $value);
                    }
                }
            ?>
        </tbody>
    </table>
</div>