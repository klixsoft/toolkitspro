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

<div class="domain_age_checker_report_container">
    <div class="domain_age_checker_report">
        <div class="row">
            <div class="col-sm-4 pe-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-link"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Domain Name</div>
                        <div class="checkurl"><?php echo $domainAge->url; ?></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 p-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-clock"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Age</div>
                        <div class="domainage"><?php echo $domainAge->domainage; ?></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 ps-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-clock"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Expire After</div>
                        <div class="domainage"><?php echo $domainAge->expireafter; ?> Days</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 pe-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-hourglass-start"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Created on</div>
                        <div class="createddate"><?php echo $domainAge->createddate; ?></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 px-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-hourglass"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Updated Date</div>
                        <div class="updatedate"><?php echo $domainAge->updatedate; ?></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 ps-sm-0">
                <div class="p-4 border">
                    <div class="result_icon me-2 float-start">
                        <i class="las la-hourglass-end"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Expiration Date</div>
                        <div class="expirydate"><?php echo $domainAge->expirydate; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>