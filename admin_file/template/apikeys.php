<?php
global $fields;
$settings = (array) get_settings("toolapikeys");
$fieldParams = apply_filters("ast/admin/apikeys", array());
?>

<div class="col-12">
    <div class="card bg-white p-4">
        <div class="api_keys_lists w-100">
            <div class="row">
                <div class="col-12 mt-1">
                    <div class="form-group">
                        <label>Word Limit</label>
                        <input type="text" value="<?php echo @$settings["wordlimit"]; ?>" class="form-control" placeholder="Word Limit" name="wordlimit">
                        <em class="text-muted">Empty means unlimited words.</em>
                    </div>
                </div>

                <?php
                    foreach($fieldParams as $k => $v){
                        $v['atts']['name'] = $k;
                        
                        if( isset($settings[$k]) ){
                            $v['value'] = $settings[$k];
                        }

                        $afterinput = '';
                        if( isset( $v['access'] ) ){
                            $afterinput .= '<em>This api key is used by these tools: ';
                            foreach($v['access'] as $textra){
                                $tool = get_tool_by("extra", $textra);
                                if( $tool ){
                                    $afterinput .= sprintf('<a href="%s" target="_blank">%s</a>, ', get_site_url("admin/tool/edit/" . $tool->id . "/"), $tool->title);
                                }
                            }
                            $afterinput = rtrim($afterinput, ", ");
                            $afterinput .= '</em>';
                        }
                        $v['after_input'] = $afterinput;

                        echo $fields->set($v)->render();
                    }
                ?>

                <div class="col-12 mt-3 text-center">
                    <button class="btn btn-primary updateAPIKeys" type="button">Update API Keys</button>
                </div>
            </div>
        </div>
    </div>
</div>