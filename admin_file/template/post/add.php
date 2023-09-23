<div class="col-md-12">
    <form action="<?php echo get_full_url(); ?>" method="post" class="post_submit_form">
        <div class="row">
            <div class="col-md-9">
                <div class="card bg-white p-3">
                    <div class="has_messages"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="post_title" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="post_slug">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" name="post_des" id="maineditor"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-white p-3 position-sticky" style="top:70px;">
                    <input type="text" name="post_id" style="display:none;" value="">
                    <input type="text" name="action" value="publish_update_post" style="display:none;">
                    <input type="text" name="post_type" value="post" style="display:none;">
                    
                    <button class="btn btn-primary btn-block publishbtn" type="submit">Publish</button>
                    <button class="btn btn-warning btn-block draftbtn" type="button">Save as Draft</button>

                    <?php echo get_image_picker_container("", "featured_image", "Featured Image"); ?>

                    <div class="form-group mt-2">
                        <label>Category</label>
                        <select name="meta[category][]" class="form-control selectcategory_select"
                            data-type="post" multiple>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Post Status</label>
                        <select name="post_status" class="form-control">
                            <?php
                                foreach(get_post_status() as $sta){
                                    echo sprintf('<option value="%s">%s</option>', $sta, ucfirst($sta));
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>