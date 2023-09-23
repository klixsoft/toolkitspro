<style>
.result_icon {
    background: var(--primary);
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    border-radius: 100%;
    color: #fff;
}

.server_status_checker_report .la-check-circle{
    font-size: 25px;
    font-weight: bold;
    color: #5ACC46;
}

.server_status_checker_report .la-times-circle{
    font-size: 25px;
    font-weight: bold;
    color: #EA5050;
}
</style>

<div class="server_status_checker_content">
    <form class="server_status_checker_submit_form">
        <div class="form-group">
            <label>Enter Domain</label>
            <div class="server_status_checker_input_container">
                <textarea class="form-control" disabled name="urls" rows="10" placeholder="Enter or Paste urls (In Each Line)..." required></textarea>
            </div>
        </div>

        <div class="button-row text-center my-4">
            <input type="text" class="d-none" name="action" value="validate_captcha">
            <input type="text" class="d-none" name="tool" value="server-status-checker">

            <?php
                echo get_tool_submit_button($tool, "Check Server Status", array(
                    "type" => "submit",
                    "disabled" => "disabled",
                    "id" => "server_status_checker_btn",
                    "class" => "btn btn-primary text-white"
                ));
            ?>
        </div>

        <div class="form-group d-none">
            <label>Result</label>

            <div class="server_status_checker_report_container">
                <div class="server_status_checker_report">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">SN</th>
                                <th>URL</th>
                                <th class="text-center">Status Code</th>
                                <th class="text-center">Remark</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>