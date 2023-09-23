<?php 
$plan = get_active_user_plan();
?>

<div class="card">
    <div class="card-body px-4">
        <div class="row">
            <div class="col-md-6 mt-4">
                <h6>Plan</h6>
                <div class="text-muted"><?php echo $plan->plan->title; ?></div>
            </div>

            <?php if( $plan->source != 'unknown' ): ?>
            <div class="col-md-6 mt-4">
                <h6>Processor</h6>
                <div class="text-muted"><?php echo strtoupper($plan->source); ?></div>
            </div>
            <?php endif; ?>

            <div class="col-md-6 mt-4">
                <h6>Amount</h6>
                <div class="text-muted">$<?php echo $plan->price; ?> / <?php echo $plan->type; ?></div>
            </div>

            <?php if( $plan->source != 'unknown' ): ?>
            <div class="col-md-6 mt-4">
                <h6>Next Payment Date</h6>
                <div class="text-muted"><?php echo $plan->expiry; ?></div>
            </div>
            <?php endif; ?>

            <div class="col-md-12">
                <hr />
            </div>

            <div class="col-md-12">
                <h6><strong>Features</strong></h6>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item ps-0">
                        <div class="d-flex justify-content-between py-1">
                            <span class="plan-name">
                                <i class="me-2 la la-check text-success"></i>
                                <strong>
                                    Daily Usage
                                </strong>
                            </span>
                            <span class="plan-value">
                                <span class="text-muted ms-2"><?php echo number_format($plan->plan->meta->dailyusage); ?></span>
                            </span>
                        </div>
                        <div class="text-muted small w-75">Number of requests that a user can perform within a 24-hour period.</div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="d-flex justify-content-between py-1">
                            <span class="plan-name">
                                <i class="me-2 la la-check text-success"></i>
                                <strong>
                                    Word Count
                                </strong>
                            </span>
                            <span class="plan-value">
                                <span class="text-muted ms-2"><?php echo number_format($plan->plan->meta->wordcount); ?></span>
                            </span>
                        </div>
                        <div class="text-muted small w-75">Maximum number of words allowed in a text, such as in a article rewrite or plagiarism checker.</div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="d-flex justify-content-between py-1">
                            <span class="plan-name">
                                <i class="me-2 la la-check text-success"></i>
                                <strong>
                                    File Size
                                </strong>
                            </span>
                            <span class="plan-value">
                                <span class="text-muted ms-2"><?php echo number_format($plan->plan->meta->filesize); ?></span>
                            </span>
                        </div>
                        <div class="text-muted small w-75">Maximum size of a file that can be uploaded, size must be in megabytes.</div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="d-flex justify-content-between py-1">
                            <span class="plan-name">
                                <i class="me-2 la la-check text-success"></i>
                                <strong>
                                    No of Image
                                </strong>
                            </span>
                            <span class="plan-value">
                                <span class="text-muted ms-2"><?php echo number_format($plan->plan->meta->imagenum); ?></span>
                            </span>
                        </div>
                        <div class="text-muted small w-75">Maximum number of images that can be uploaded on supported tools.</div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="d-flex justify-content-between py-1">
                            <span class="plan-name">
                                <i class="me-2 la la-check text-success"></i>
                                <strong>
                                    No of URLs
                                </strong>
                            </span>
                            <span class="plan-value">
                                <span class="text-muted ms-2"><?php echo number_format($plan->plan->meta->urlnums); ?></span>
                            </span>
                        </div>
                        <div class="text-muted small w-75">Maximum number of urls that can be processed in single request.</div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="py-1">
                            <strong> 
                                <?php if( filter_var($plan->plan->meta->noads, FILTER_VALIDATE_BOOLEAN) ): ?>
                                <i class="me-2 la la-check text-success"></i> 
                                <?php else: ?>
                                <i class="me-2 la la-times text-danger"></i> 
                                <?php endif; ?>
                            Ad Free </strong>
                        </div>
                    </li>
                    <li class="list-group-item ps-0">
                        <div class="py-1">
                            <strong> 
                            <?php if( filter_var($plan->plan->meta->allowapi, FILTER_VALIDATE_BOOLEAN) ): ?>
                            <i class="me-2 la la-check text-success"></i> 
                            <?php else: ?>
                            <i class="me-2 la la-times text-danger"></i> 
                            <?php endif; ?>    
                            API Access </strong>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>