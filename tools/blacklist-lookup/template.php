<style>
.blacklist_lookup_report_container a {
    text-decoration: none;
    color: #000;
}

.blacklist_lookup_report_container a:hover{
    text-decoration: underline;
}

.tbl-header table,
.tbl-content table{
    table-layout: fixed;
    margin-bottom: 0;
}

.tbl-header table tr td:nth-child(1){
    width: 8%;
}

.tbl-header table tr td:nth-child(2){
    width: 75%;
}

.tbl-header table tr td:nth-child(3){
    width: 17%;
}

.tbl-content table tr td:nth-child(1){
    width: 8%;
    text-align:center;
}

.tbl-content table tr td:nth-child(2){
    width: 73%;
}

.tbl-content table tr td:nth-child(3){
    width: 16%;
    text-align:center;
}

.blacklist_lookup_report_container .la-check-circle{
    font-size: 25px;
    font-weight: bold;
    color: #EA5050;
}

.blacklist_lookup_report_container .la-times-circle{
    font-size: 25px;
    font-weight: bold;
    color: #5ACC46;
}
</style>

<div class="blacklist_lookup_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="blacklist_lookup_submit_form">
        <div class="form-group">
            <label>Enter Domain</label>
            <div class="blacklist_lookup_input_container">
                <input class="form-control" name="url" type="url" placeholder="Enter or Paste url..." required />
            </div>
        </div>

        <div class="button-group text-center my-4">
            <button type="submit" id="blacklist_lookup_btn"
                class="btn btn-primary text-white">Check Blacklist</button>
        </div>

        <div class="form-group <?php echo $report ? '' : 'd-none'; ?>">
            <label>Result</label>

            <div class="blacklist_lookup_report_container">
                <div class="blacklist_lookup_report">
                    <div class="row">
                        <div class="col-12">
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>

                    <div class="tbl-header mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #F6F8FA;text-align:center;">
                                    <td>SN#</td>
                                    <td>URL</td>
                                    <td>Listed</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="custom_scrollbar tbl-content">
                        <table class="table table-bordered" cellpadding="0" cellspacing="0" border="0">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>