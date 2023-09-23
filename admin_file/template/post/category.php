<div class="col-md-5">
    <div class="card bg-white p-3">
        <form action="<?php echo get_full_url(); ?>" method="post" class="add_category_form">
            <h5 class="title mb-3" style="text-transform:uppercase;font-weight:bold;text-align:center;">Category</h5>

            <div class="form-group">
                <label>Name</label>
                <input type="text" value="<?php echo !empty( $categorydata ) ? $categorydata->title : ""; ?>" class="form-control" required name="cat_title" placeholder="Category Name">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea type="text" class="form-control"rows="5" name="cat_des" placeholder="Category Description"><?php echo !empty( $categorydata ) ? $categorydata->description : ""; ?></textarea>
            </div>

            <div class="button-group">
                <input type="text" name="cat_of" value="post" class="d-none">
                <input type="text" name="cat_id" value="<?php echo !empty( $categorydata ) ? $categorydata->id : ""; ?>" class="d-none">
                <input type="text" name="action" value="add_category" class="d-none">
                
                <button type="submit" class="btn btn-primary updatecategory w-100"><?php echo !empty( $categorydata ) ? "Update" : "Add"; ?> Category</button>
                <?php if( !empty($categorydata) ): ?>
                <a type="type" href="<?php echo get_site_url("admin/post/category/"); ?>" class="btn btn-warning w-100 mt-2">Cancel Category Update</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="col-md-7">
    <div class="card bg-white p-3">
        <table class="table table-bordered table-datatable" data-action="ast_get_all_posts_category">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Count</th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Count</th>
                    <th class="no-sort">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>