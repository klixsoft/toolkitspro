<div class="card card-box checkoutloading position-relative">
    <div class="card-header paymentcard p-3">Payment</div>
    <div class="card-body">
        <div class="row">
            <?php 
                $total = count($payments);
                if( $total > 1 ):
                foreach($payments as $key => $payment): 
                    if( isset( $settings[$payment] ) ):
                        $setting = (object) $settings[$payment];
                        if( filter_var($setting->enable, FILTER_VALIDATE_BOOLEAN) ): ?>
                            <div class="col-md-6">
                                <div class="custom-radio-checkbox single_payment_option">
                                    <label class="radio-checkbox-wrapper">
                                        <input type="radio" class="radio-checkbox-input gateway-checkbox" name="gateway" value="<?php echo $payment; ?>" <?php echo $payment == $defaultpayment ? "checked" : ""; ?>>
                                        <span class="radio-checkbox-tile w-100">
                                            <i class="<?php echo $setting->icon; ?>"></i>
                                            <span><?php echo $setting->text; ?></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="payment_options mt-3">
            <?php
                /**
                 * Include default payments
                 */
                echo apply_filters("tkp/payment/options/$defaultpayment", "", $order, $orderType);
            ?>
        </div>
    </div>

    <div class="overlay">
        <div class="loadingdot"></div>
    </div>
</div>