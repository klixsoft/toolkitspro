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
                                <input type="text" class="form-control" name="post_title" required
                                    value="<?php echo $tooldata->title; ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="post_slug"
                                    value="<?php echo $tooldata->slug; ?>">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Tool Description</label>
                                <textarea type="text" class="form-control" name="post_des"
                                    id="maineditor"><?php echo $tooldata->description; ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card bg-white">
                    <div class="card-header d-flex align-items-center justify-content-between position-sticky" style="top:57px;background:#fff;z-index:999;">
                        <div class="title">FAQ Questions</div>
                        <button type="button" class="btn btn-primary addFaqQuestion"><i class="las la-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="faq_question_container">
                            <?php
                                foreach($faqQuestions as $key => $faq){
                                    echo sprintf('<div class="form-group faq_single" data-index="%d">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Question . . ." value="%s" name="meta[faqQuestions][%d][qn]" aria-label="Question" aria-describedby="faqRemoveBtn%d">
                                            <span class="input-group-text removeBtn" id="faqRemoveBtn%d">-</span>
                                        </div>
                                        <textarea type="text" placeholder="Answer . . ." row="4" class="form-control" name="meta[faqQuestions][%d][ans]">%s</textarea>
                                    </div>', $key, $faq['qn'], $key, $key, $key, $key, $faq['ans']);
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                    /**
                     * Render Additional options
                     * Such as Seo details
                     */

                    do_action("ast/post/additional/settings", $tooldata, "tool");
                ?>

            </div>

            <div class="col-md-3">
                <div class="card bg-white p-3 position-sticky" style="top:70px;">
                    <input type="text" name="post_id" style="display:none;" value="<?php echo $tooldata->id; ?>">
                    <input type="text" name="action" value="publish_update_post" style="display:none;">
                    <input type="text" name="post_type" value="tool" style="display:none;">

                    <button class="btn btn-primary btn-block publishbtn" type="submit">Update Tool</button>
                    <a href="<?php echo get_tool_url("slug", $tooldata->slug); ?>" target="_blank"
                        class="btn btn-warning text-white btn-block rounded-0" type="button">View Tool</a>

                    <?php echo get_image_picker_container($featuredimage, "featured_image", "Featured Image"); ?>

                    <div class="form-group mt-3">
                        <label>Category</label>
                        <select name="meta[category][]" class="form-control selectcategory_select" data-type="tool"
                            multiple>
                            <?php
                                if( isset( $category ) && is_array( $category ) ){
                                    foreach($category as $catid){
                                        $catObj = get_category($catid);
                                        if( $catObj ){
                                            echo sprintf('<option value="%s" selected>%s</option>', $catid, $catObj['title']);
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label>Tool Status</label>
                        <select name="post_status" class="form-control">
                            <?php
                                foreach(get_post_status() as $sta){
                                    $selected = $sta == $tooldata->status ? "selected" : "";
                                    echo sprintf('<option value="%s" %s>%s</option>', $sta, $selected, ucfirst($sta));
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>