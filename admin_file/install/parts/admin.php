<div class="form-group text-start">
    <label>Full Name:</label>
    <input type="text" class="form-control mt-1" name="user_name" value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Email:</label>
    <input type="text" class="form-control mt-1" name="user_email" value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Password:</label>
    <input type="text" class="form-control mt-1" name="user_password" value="<?php echo isset($_SESSION['user_password']) ? $_SESSION['user_password'] : ''; ?>">
</div>

<div class="button-row mt-4">
    <input type="text" class="d-none" name="websiteurl" value="<?php echo $_SERVER['SCRIPT_URI']; ?>">
    <button type="button" data-current="<?php echo Installation::current(); ?>" data-prev="<?php echo Installation::prev(); ?>" class="action-button previous_button">Back</button>
    <button type="button" data-next="<?php echo Installation::next(); ?>" class="proceedBtn action-button">Continue</button>
</div>