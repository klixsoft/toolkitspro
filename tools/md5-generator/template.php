<style>
.copy-clipboard {
    width: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    font-size: 1.2rem;
}

.md5-generator_report .row {
    border: 1px solid #dee2e6;
    margin: 0;
    border-top: none;
}

.md5-generator_report .row:nth-child(1) {
    border-top: 1px solid #dee2e6;
}

.md5-generator_report .row .col-md-2,
.md5-generator_report .row .col-md-9 {
    border-right: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-left: 15px !important;
}

.md5-generator_report .row .col-md-9 .btn {
    display: none;
}

@media only screen and (max-width:580px) {
    .md5-generator_report .row .col-md-1 {
        display: none;
    }

    .md5-generator_report .row .col-md-9 .btn {
        display: flex;
        position: absolute;
        right: 10px;
    }

    .md5-generator_report .row .col-md-2,
    .md5-generator_report .row .col-md-9 {
        padding: 20px 15px !important;
    }
}

.passed_value {
    word-wrap: break-word;
    width: 100%;
}
</style>

<div class="md5-generator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="md5-generator_submit_form">
        <div class="form-group">
            <label>Enter Password</label>
            <div class="md5-generator_input_container">
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
            <input type="text" value="md5-generator" name="tool" class="d-none">
            <input type="text" value="process_md5-generator_checker" name="action" class="d-none">
            
            <button type="submit" id="md5-generator_btn" class="btn btn-primary text-white">Encrypt
                Password</button>
        </div>

        <div class="form-group d-none">
            <label>Result</label>

            <div class="md5-generator_report_container mt-3">
                <div class="md5-generator_report"></div>
            </div>
        </div>
    </form>
</div>