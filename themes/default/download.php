<style>
#loadingAnimation{
    display: flex;
    justify-content: center;
    align-items: center;
}

#loadingAnimation svg {
    width: 200px;
    height: 200px;
}

#loadingAnimation .downloaded{
    width: 150px;
    height: 150px;
}

#loadingAnimation svg rect {
    fill: var(--primary) !important;
}
</style>

<div class="container my-5">
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="card rounded-0">
                <div class="card-header py-3"><strong>Download File</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-responsive">
                                <?php
                                    foreach($filedata['atts'] as $title => $value){
                                        echo sprintf('<tr>
                                            <td><strong>%s:</strong></td>
                                            <td>%s</td>
                                        </tr>', $title, $value);
                                    }
                                ?>
                            </table>
                        </div>

                        <div class="col-md-6" id="loadingAnimation">
                            <svg class="downloading" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="margin: auto; display: block; shape-rendering: auto;" viewBox="0 0 100 100"
                                preserveAspectRatio="xMidYMid">
                                <g transform="rotate(0 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(30 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(60 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.75s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(90 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(120 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(150 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.5s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(180 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(210 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(240 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.25s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(270 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(300 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s"
                                            begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(330 50 50)">
                                    <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
                                        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s"
                                            repeatCount="indefinite"></animate>
                                    </rect>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card_footer py-3 text-center" id="footertext">
                    <?php
                        echo str_replace("{{COUNTDOWN}}", '<strong id="countdown">'.$countdown.'</strong>', @$settings->beforetext);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
<?php if( $countdown > 0 ): ?>
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
let redirectUrl = window.location.href;
let countdown = <?php echo $countdown; ?>;
let timeLeft = countdown;

function redirect() {
    if (!params.start) {
        window.location.href = "<?php echo $downloadurl; ?>?start=true";
    }
}

let downloadTimer = setInterval(function() {
    if (timeLeft <= 0) {
        clearInterval(downloadTimer);
        redirect();
        document.getElementById("footertext").innerHTML = `<?php echo @$settings->aftertext; ?>`;
        document.getElementById("loadingAnimation").innerHTML = `<svg class="downloaded" xmlns="http://www.w3.org/2000/svg" viewBox="3 3 16 16"><g transform="matrix(1.99997 0 0 1.99997-10.994-2071.68)" fill="#da4453"><rect y="1037.36" x="7" height="8" width="8" fill="#009E69" rx="4"/><path d="m123.86 12.966l-11.08-11.08c-1.52-1.521-3.368-2.281-5.54-2.281-2.173 0-4.02.76-5.541 2.281l-53.45 53.53-23.953-24.04c-1.521-1.521-3.368-2.281-5.54-2.281-2.173 0-4.02.76-5.541 2.281l-11.08 11.08c-1.521 1.521-2.281 3.368-2.281 5.541 0 2.172.76 4.02 2.281 5.54l29.493 29.493 11.08 11.08c1.52 1.521 3.367 2.281 5.54 2.281 2.172 0 4.02-.761 5.54-2.281l11.08-11.08 58.986-58.986c1.52-1.521 2.281-3.368 2.281-5.541.0001-2.172-.761-4.02-2.281-5.54" fill="#fff" transform="matrix(.0436 0 0 .0436 8.177 1039.72)" stroke="none" stroke-width="9.512"/></g></svg>`;
    } else {
        document.getElementById("countdown").innerHTML = timeLeft + "";
    }
    timeLeft -= 1;
}, 1000);
<?php else: ?>
document.getElementById("footertext").innerHTML = `<?php echo @$settings->aftertext; ?>`;
document.getElementById("loadingAnimation").innerHTML = `<svg class="downloaded" xmlns="http://www.w3.org/2000/svg" viewBox="3 3 16 16"><g transform="matrix(1.99997 0 0 1.99997-10.994-2071.68)" fill="#da4453"><rect y="1037.36" x="7" height="8" width="8" fill="#009E69" rx="4"/><path d="m123.86 12.966l-11.08-11.08c-1.52-1.521-3.368-2.281-5.54-2.281-2.173 0-4.02.76-5.541 2.281l-53.45 53.53-23.953-24.04c-1.521-1.521-3.368-2.281-5.54-2.281-2.173 0-4.02.76-5.541 2.281l-11.08 11.08c-1.521 1.521-2.281 3.368-2.281 5.541 0 2.172.76 4.02 2.281 5.54l29.493 29.493 11.08 11.08c1.52 1.521 3.367 2.281 5.54 2.281 2.172 0 4.02-.761 5.54-2.281l11.08-11.08 58.986-58.986c1.52-1.521 2.281-3.368 2.281-5.541.0001-2.172-.761-4.02-2.281-5.54" fill="#fff" transform="matrix(.0436 0 0 .0436 8.177 1039.72)" stroke="none" stroke-width="9.512"/></g></svg>`;
<?php endif; ?>
</script>