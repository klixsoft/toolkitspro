<style>
.headers_table tr td {
    word-wrap: break-word;
    word-break: break-all;
    white-space: normal;
}

.headers_table tr td:first-child {
    width: 40%;
}

.headers_table .table thead tr th{
    background: -webkit-linear-gradient(30deg, var(--primary), #f73333);
    background: -o-linear-gradient(30deg, var(--primary), #f73333);
    background: linear-gradient(120deg, var(--primary), #f73333);
    color: #fff;
}
</style>
<div class="table-responsive headers_table mt-3">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th colspan="3" class="p-3 text-center">Suggestions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $whoisURL = tool_exists("whois-checker") ? get_tool_url("extra", "whois-checker") : "";
                foreach($result as $key => $value){
                    $action = '<button type="button" data-domain="https://'.$value['domain'].'/" data-target="'.$whoisURL.'" class="checkWhoisRecord btn btn-warning btn-sm bg-warning text-white">Check Whois</button>';

                    $available = '<strong class="text-danger">Already Registered</strong>';
                    if( ! filter_var($value['already'], FILTER_VALIDATE_BOOLEAN) ){
                        $available = '<strong class="text-success">Available</strong>';
                        $action = sprintf('<button href="%s" target="_blank" class="btn btn-success bg-success text-white btn-sm">Buy Now</button>', $value['buy']);
                    }
                    
                    echo sprintf('<tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                    </tr>', $value['domain'], $available, $action);
                }
            ?>
        </tbody>
    </table>
</div>

<script>
const checkWhoisRecordBtns = document.getElementsByClassName("checkWhoisRecord");
for (var i = 0; i < checkWhoisRecordBtns.length; i++) {
    checkWhoisRecordBtns[i].addEventListener("click", function() {
        const domain = this.getAttribute("data-domain");
        const target = this.getAttribute("data-target");
        if (domain && target) {
            const json = {
                target: "#videoDownloadInput",
                value: domain,
                form: ".video_downloader_form"
            };

            if (typeof window.localStorage == 'object') {
                window.localStorage.setItem("setValue", JSON.stringify(json));
                window.open(target, '_blank').focus();
            }
        }
    });
}
</script>