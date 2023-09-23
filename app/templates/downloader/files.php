<table class="video_download_result_header">
    <tr>
        <th colspan="4"><?php echo $out->title; ?></th>
    </tr>
</table>

<div class="table-responsive">
    <table class="video_download_result_data table mb-0">
        <thead>
            <tr>
                <?php echo $this->getHeader("file"); ?>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php
                foreach( $mediaData as $o ){
                    $downloadLink = $this->download_link($o);
                    echo sprintf(
                        '<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td><a href="%s" class="btn btn-primary downloadbtn" target="_blank"><i class="las la-download me-1"></i> Download</a>
                        </tr>',
                        @$o->filename,
                        @$o->extension,
                        format_size(@$o->size),
                        $downloadLink
                    );
                }
            ?>
        </tbody>
    </table>
</div>