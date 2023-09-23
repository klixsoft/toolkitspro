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

.overview-row {
    display: flex;
    flex-wrap: wrap;
}

.col-part {
    flex: 0 0 auto;
    width: 50%;
}

.col-full {
    flex: 1 0 0%;
}
</style>

<div class="domain_hosting_checker_report_container">
    <div class="domain_hosting_checker_report">
        <div class="overview-row">
            <div class="col-full p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-link"></i>
                </div>
                <div>
                    <div class="fw-bold">Domain Name</div>
                    <div class="checkurl"><?php echo $domain; ?></div>
                </div>
            </div>

            <div class="col-full p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-map-marked"></i>
                </div>
                <div>
                    <div class="fw-bold">IP</div>
                    <div class="domainip"><?php echo @$info['content']['ip']; ?></div>
                </div>
            </div>

            <div class="col-full p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-server"></i>
                </div>
                <div>
                    <div class="fw-bold">Hosting Provider</div>
                    <div class="hostingprovider"><?php echo @$info['content']['isp']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>