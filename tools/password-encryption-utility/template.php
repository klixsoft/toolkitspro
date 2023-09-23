<style>
.copy-clipboard {
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    font-size: 1.2rem;
}

.password-encryption-utility_report .row {
    border: 1px solid #dee2e6;
    margin: 0;
    border-top: none;
}

.password-encryption-utility_report .row:nth-child(1) {
    border-top: 1px solid #dee2e6;
}

.password-encryption-utility_report .row .col-md-2,
.password-encryption-utility_report .row .col-md-9 {
    border-right: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-left: 15px !important;
}

.password-encryption-utility_report .row .col-md-9 .btn {
    display: none;
}

@media only screen and (max-width:580px) {
    .password-encryption-utility_report .row .col-md-1 {
        display: none;
    }

    .password-encryption-utility_report .row .col-md-9 .btn {
        display: flex;
        position: absolute;
        right: 10px;
    }

    .password-encryption-utility_report .row .col-md-2,
    .password-encryption-utility_report .row .col-md-9 {
        padding: 20px 15px !important;
    }
}

.passed_value {
    word-wrap: break-word;
    width: 100%;
}
</style>

<div class="password-encryption-utility_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="password-encryption-utility_submit_form">
        <div class="form-group">
            <label>Enter Password</label>
            <div class="password-encryption-utility_input_container">
                <input class="form-control" name="password" type="text" required />
            </div>
        </div>

        <?php
            /**
             * Render Captcha Settings
             */
            do_action("ast/captcha/render", $tool, $report); 
        ?>

        <div class="button-group text-center my-4">
            <input type="text" value="password-encryption-utility" name="tool" class="d-none">
            <input type="text" value="process_password-encryption-utility_checker" name="action" class="d-none">
            
            <button type="submit" id="password-encryption-utility_btn" class="btn btn-primary text-white">Encrypt
                Password</button>
        </div>

        <div class="form-group d-none">
            <label>Result</label>

            <div class="password-encryption-utility_report_container mt-3">
                <div class="password-encryption-utility_report"></div>
            </div>
        </div>
    </form>
</div>