<form class="on_submit_update_profile" action="<?php echo get_site_url("profile"); ?>" method="post">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" disabled value="<?php echo $user->username; ?>">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" disabled value="<?php echo $user->email; ?>">
                    </div>
                </div>

                <div class="col-sm-12 mt-3">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $user->name; ?>">
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <h6><strong>Change Password</strong></h6>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control">
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <h6><strong>Additional Information</strong></h6>
                </div>

                <div class="col-sm-12 mt-3">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" value="<?php echo @$user->meta->company; ?>" name="meta[company]" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Street Address 1</label>
                        <input type="text" value="<?php echo @$user->meta->address1; ?>" name="meta[address1]" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Street Address 2</label>
                        <input type="text" value="<?php echo @$user->meta->address2; ?>" name="meta[address2]" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" value="<?php echo @$user->meta->country; ?>" name="meta[country]" class="form-control">
                    </div>
                </div>

                <div class="col-sm-6 mt-3">
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" value="<?php echo @$user->meta->postcode; ?>" name="meta[postcode]" class="form-control">
                    </div>
                </div>

                <div class="col-12 text-secondary text-center mt-4">
                    <input type="text" style="display:none;" name="user_id" value="<?php echo $user->id; ?>">
                    <input type="text" style="display:none;" name="action" value="publish_update_user">
                    <input type="submit" class="btn btn-primary px-4 updateprofile" value="Save Changes">
                </div>
            </div>
        </div>
    </div>
</form>