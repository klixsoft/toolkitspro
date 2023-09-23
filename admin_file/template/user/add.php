<div class="col-md-9">
    <form action="<?php echo get_full_url(); ?>" method="post" class="post_submit_form">
        <div class="card bg-white p-3">
            <div class="has_messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control">
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="col-md-3">
    <div class="card bg-white p-3">
        <input type="text" name="user_id" style="display:none;" value="">
        <input type="text" name="action" value="publish_update_user" style="display:none;">
        <button class="btn btn-primary btn-block publishbtn" type="submit">Publish</button>
        
        <?php echo get_image_picker_container("", "meta[featured_image]", "User Profile"); ?>

        <div class="from-group mt-3">
            <label>Role</label>
            <select class="form-control" name="role">
                <?php
                    foreach(get_roles() as $role){
                        echo sprintf('<option value="%s">%s</option>', $role, ucfirst($role));
                    }
                ?>
            </select>
        </div>

        <div class="from-group mt-3">
            <label>Status</label>
            <select class="form-control" name="status">
                <?php
                    foreach(get_user_status() as $status){
                        echo sprintf('<option value="%s">%s</option>', $status, ucfirst($status));
                    }
                ?>
            </select>
        </div>
    </div>
</div>