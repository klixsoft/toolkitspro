<div class="col-md-9">
    <form action="<?php echo get_full_url(); ?>" method="post" class="post_submit_form">
        <div class="card bg-white p-3">
            <div class="has_messages"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="email" disabled value="<?php echo $user->username; ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" disabled value="<?php echo $user->email; ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?php echo $user->name; ?>" required class="form-control">
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
        
        <input type="text" name="user_id" style="display:none;" value="<?php echo $user->id; ?>">
        <input type="text" name="action" value="publish_update_user" style="display:none;">
        <button class="btn btn-primary btn-block publishbtn" type="submit">Update User</button>

        <?php echo get_image_picker_container($featuredimage, "meta[featured_image]", "User Profile"); ?>

        <div class="from-group mt-3">
            <label>Role</label>
            <select class="form-control" name="role">
                <?php
                    foreach(get_roles() as $role){
                        $selected = strtolower($role) == $user->role ? "selected" : "";
                        echo sprintf('<option value="%s" %s>%s</option>', $role, $selected, ucfirst($role));
                    }
                ?>
            </select>
        </div>

        <div class="from-group mt-3">
            <label>Status</label>
            <select class="form-control" name="status">
                <?php
                    foreach(get_user_status() as $status){
                        $selected = strtolower($status) == $user->status ? "selected" : "";
                        echo sprintf('<option value="%s" %s>%s</option>', $status, $selected, ucfirst($status));
                    }
                ?>
            </select>
        </div>
    </div>
</div>