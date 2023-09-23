<style>
    table tbody td{
        word-wrap: break-word;
    }
</style>

<div class="find-dns-records_report_container">
    <div class="find-dns-records_report">
        <table class="table table-bordered mt-3" style="table-layout:fixed;">
            <colgroup>
                <col style="width:10%;">
                <col style="width:25%;">
                <col style="width:15%;">
                <col style="width:50%;">
            </colgroup>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>TTL</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $output; ?>
            </tbody>
        </table>
    </div>
</div>