<style>
.copyAPIWrapper {
    background: rgb(var(--primaryrgb), 0.05);
    border: 1px solid var(--primary);
    border-radius: 3px;
    padding: 13px 15px;
    text-align: center;
}

.copyAPIWrapper .copyBtn {
    position: absolute;
    top: 13%;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.5rem;
    outline: none;
    color: #7a828b;
}

.api_summary{
    flex-wrap:wrap;
    justify-content:space-between;
}

.api_summary .progress{
    min-width:75%;
}
</style>

<?php 
$plan = get_active_user_plan();
if( $plan->plan->extra != 'nodelete' ):
$percentage = round(intval($plan->apidata->total_request) / intval($plan->apidata->usagelimit) * 100, 2);
?>
<div class="card p-3">
    <div class="row">
        <div class="col-12">
            <h6><strong>API Keys</strong></h6>

            <div class="alert alert-success mt-3">Please save your secret key and do not show it to anyone. You can see
                it by providing password.</div>

            <div class="form-group copyAPIWrapper position-relative">
                <div class="text"><?php echo $plan->apikey; ?></div>
                <!-- <button type="button" class="copyBtn"><i class="las la-copy"></i></button> -->
            </div>

            <h6 class="mt-4"><strong>Monthly Limit</strong></h6>
            <p>Below, You'll find a summary of API usage for your organization.</p>

            <div class="api_summary d-flex align-items-center">
                <div class="progress">
                    <div class="progress-bar bg-primary" style="width: <?php echo $percentage; ?>%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="summary_text"><?php echo number_format($plan->apidata->total_request); ?> / <?php echo number_format($plan->apidata->usagelimit); ?> Requests</div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card p-3">
    <div class="row">
        <div class="col-12">
            <h6><strong>API Keys</strong></h6>

            <div class="alert alert-danger mt-3">You must upgrade the plan to use the API Features.</div>
        </div>
    </div>
</div>
<?php endif; ?>