<div class="form-group text-start">
    <label>Domain Host:</label>
    <input type="text" class="form-control mt-1" name="host" value="<?php echo isset($_SESSION['host']) ? $_SESSION['host'] : 'localhost'; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Database Name:</label>
    <input type="text" class="form-control mt-1" name="dbname" value="<?php echo isset($_SESSION['dbname']) ? $_SESSION['dbname'] : ''; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Username:</label>
    <input type="text" class="form-control mt-1" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Password:</label>
    <input type="text" class="form-control mt-1" name="password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
</div>

<div class="form-group text-start mt-3">
    <label>Table Prefix:</label>
    <input type="text" class="form-control mt-1" name="prefix" value="<?php echo isset($_SESSION['prefix']) ? $_SESSION['prefix'] : 'tkp_'; ?>">
</div>

<div class="button-row mt-4">
    <button type="button" data-current="<?php echo Installation::current(); ?>" data-prev="<?php echo Installation::prev(); ?>" class="action-button previous_button">Back</button>
    <button type="button" data-next="<?php echo Installation::next(); ?>" class="proceedBtn action-button">Continue</button>
</div>       