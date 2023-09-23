<style>
.copy-clipboard {
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    font-size: 1.2rem;
}

.wordpress-password-generator_report .row {
    border: 1px solid #dee2e6;
    margin: 0;
    border-top: none;
}

.wordpress-password-generator_report .row:nth-child(1) {
    border-top: 1px solid #dee2e6;
}

.wordpress-password-generator_report .row .col-md-2,
.wordpress-password-generator_report .row .col-md-9 {
    border-right: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-left: 15px !important;
}

.wordpress-password-generator_report .row .col-md-9 .btn {
    display: none;
}

@media only screen and (max-width:580px) {
    .wordpress-password-generator_report .row .col-md-1 {
        display: none;
    }

    .wordpress-password-generator_report .row .col-md-9 .btn {
        display: flex;
        position: absolute;
        right: 10px;
    }

    .wordpress-password-generator_report .row .col-md-2,
    .wordpress-password-generator_report .row .col-md-9 {
        padding: 20px 15px !important;
    }
}

.passed_value {
    word-wrap: break-word;
    width: 100%;
}
</style>

<div class="wordpress-password-generator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="wordpress-password-generator_submit_form">
        <div class="form-group">
            <label>Enter Password</label>
            <div class="wordpress-password-generator_input_container">
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
            <input type="text" value="wordpress-password-generator" name="tool" class="d-none">
            <input type="text" value="process_wordpress-password-generator_checker" name="action" class="d-none">
            
            <button type="submit" id="wordpress-password-generator_btn" class="btn btn-primary text-white">Encrypt
                Password</button>
        </div>

        <div class="form-group d-none">
            <label>Result</label>

            <div class="wordpress-password-generator_report_container mt-3">
                <div class="wordpress-password-generator_report"></div>
            </div>
        </div>
    </form>
</div>