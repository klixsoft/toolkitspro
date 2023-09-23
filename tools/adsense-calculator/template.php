<style>
.adsense_calculator_report img {
    max-width: 48px;
}
</style>

<div class="adsense_calculator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="adsense_calculator_submit_form">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-normal">Daily Page Impression</label>
                    <div class="backlink_maker_input_container">
                        <input class="form-control" name="pageimpression" type="number" placeholder="0" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-normal">Click Through Rate (%)</label>
                    <div class="backlink_maker_input_container">
                        <input class="form-control" name="ctr" type="number" placeholder="0" />
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-normal">Cost Per Click</label>
                    <div class="backlink_maker_input_container">
                        <input class="form-control" name="cpc" type="number" placeholder="0" />
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <label>Result</label>

            <div class="adsense_calculator_report_container">
                <div class="adsense_calculator_report">
                    <div class="row mx-0 mt-2 bg-light">
                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-dollar-sign"></i>
                            </div>
                            <div>
                                <div>Daily Earning</div>
                                <div class="dailyearning fw-bold">0</div>
                            </div>
                        </div>

                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-dollar-sign"></i>
                            </div>
                            <div>
                                <div>Monthly Earning</div>
                                <div class="monthlyearning fw-bold">0</div>
                            </div>
                        </div>

                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-la-dollar-sign"></i>
                            </div>
                            <div>
                                <div>Yearly Earning</div>
                                <div class="yearlyearning fw-bold">0</div>
                            </div>
                        </div>

                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-mouse-pointer"></i>
                            </div>
                            <div>
                                <div>Daily Clicks</div>
                                <div class="dailyclicks fw-bold">0</div>
                            </div>
                        </div>

                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-mouse-pointer"></i>
                            </div>
                            <div>
                                <div>Monthly Clicks</div>
                                <div class="monthlyclicks fw-bold">0</div>
                            </div>
                        </div>

                        <div class="col p-4 border" style="min-width:33.33%;">
                            <div class="result_icon me-2 float-start">
                                <i class="las la-mouse-pointer"></i>
                            </div>
                            <div>
                                <div>Yearly Clicks</div>
                                <div class="yearlyclicks fw-bold">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>