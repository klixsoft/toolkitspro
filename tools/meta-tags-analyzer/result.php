<div class="meta_tag_analyzed_result w-100 mt-3">
    <style>
        .meta_tag_analyzed_result {
            overflow-x:auto;
        }

        .meta-tags-analyzer_report table td {
            padding: 15px
        }

        .meta-tags-analyzer_report table td i.text-muted{
            width:85%;
            display: block;
            word-wrap: break-word;
        }
    </style>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>URL</td>
                <td><?php echo trim($_POST['url']); ?></td>
            </tr>
            <tr>
                <td>Meta Title</td>
                <td>
                    <?php
                    if( !empty($response->title) ){
                        $titleLength = strlen($response->title);
                        echo sprintf(
                            '<div class="text-%s"><i class="la la-%s"></i> Try to keep the title under 60 characters (%s characters)</div>', 
                            $titleLength > 60 ? 'danger' : 'success',
                            $titleLength > 60 ? 'times' : 'check',
                            $titleLength
                        );

                        echo sprintf('<i class="text-muted">%s</i>', $response->desc);
                    }else{
                        echo '<div class="text-danger"><i class="la la-times"></i> Try to add meta title!!!</div>';
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td>Meta Description</td>
                <td>
                    <?php
                    if( !empty($response->desc) ){
                        $descLength = strlen($response->desc);
                        $descValid = $descLength > 50 && $descLength < 161;

                        echo sprintf(
                            '<div class="text-%s"><i class="la la-%s"></i> Try to keep the meta description between 50 - 160 characters (%s characters)</div>',
                            $descValid ? 'success' : 'danger',
                            $descValid ? 'check' : 'times',
                            $descLength
                        );
                        
                        echo sprintf('<i class="text-muted">%s</i>', $response->desc);
                    }else{
                        echo '<div class="text-danger"><i class="la la-times"></i> Try to add meta description!!!</div>';
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td>Meta Keywords</td>
                <td>
                    <?php
                    $keywordLength = @strlen($response->keywords) ?? 0;
                    sprintf(
                        '<div class="text-%s"><i class="la la-%s"></i> Meta keywords are not recommended anymore (%s characters)</div>',
                        $keywordLength ? 'danger' : 'success',
                        $keywordLength ? 'times' : 'check',
                        $keywordLength
                    );

                    echo sprintf('<i class="text-muted">%s</i>', @$response->keywords);
                ?>
                </td>
            </tr>
            <tr>
                <td>Robots</td>
                <td>
                    <?php
                    echo sprintf(
                        '<div class="text-%s"><i class="la la-%s"></i> Search engines are allowed to index your webpage</div>',
                        !$response->isindex ? 'danger' : 'success',
                        !$response->isindex ? 'times' : 'check'
                    );

                    echo sprintf('<i class="text-muted">%s</i>', @$response->robots);
                ?>
                </td>
            </tr>
            <tr>
                <td>View Port</td>
                <td>
                    <?php
                    echo sprintf(
                        '<div class="text-%s"><i class="la la-%s"></i> Meta viewport is set</div>',
                        empty($response->viewport) ? 'danger' : 'success',
                        empty($response->viewport) ? 'times' : 'check'
                    );

                    echo sprintf('<i class="text-muted">%s</i>', @$response->viewport);
                ?>
                </td>
            </tr>
            <tr>
                <td>Open Graph</td>
                <td>
                    <?php
                    echo sprintf(
                        '<div class="text-%s"><i class="la la-%s"></i> Try to add open graph meta information.</div>',
                        empty($response->openg) ? 'danger' : 'success',
                        empty($response->openg) ? 'times' : 'check'
                    );
                ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>