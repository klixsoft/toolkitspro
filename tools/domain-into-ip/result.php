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
</style>

<div class="domain_into_ip_report_container">
    <div class="domain_into_ip_report">
        <div class="row">
            <div class="col pe-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-link"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Domain Name</div>
                        <div class="checkurl"><?php echo $domain; ?></div>
                    </div>
                </div>
            </div>

            <div class="col px-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-map-marked"></i>
                    </div>
                    <div>
                        <div class="fw-bold">IP</div>
                        <div class="domainip"><?php echo @$info['content']['ip']; ?></div>
                    </div>
                </div>
            </div>

            <div class="col ps-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-globe"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Country</div>
                        <div class="country"><?php echo @$info['content']['country']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>