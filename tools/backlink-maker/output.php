<style>
.backlink_maker_report_container a {
    text-decoration: none;
    color: #000;
}

.backlink_maker_report_container a:hover{
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

.backlink_maker_report_container .la-check-circle{
    font-size: 25px;
    font-weight: bold;
    color: #5ACC46;
}

.backlink_maker_report_container .la-times-circle{
    font-size: 25px;
    font-weight: bold;
    color: #EA5050;
}

body .video_downloader .la-copy{
    left:-35%;
}
</style>

<div class="backlink_maker_report_container">
    <div class="backlink_maker_report">
        <div class="row">
            <div class="col-12">
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
            </div>
        </div>

        <div class="tbl-header mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #F6F8FA;text-align:center;">
                        <td>SN#</td>
                        <td>URL</td>
                        <td>Status</td>
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