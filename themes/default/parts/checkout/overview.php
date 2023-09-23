<div class="card card-box checkoutloading mt-3 mt-md-0 position-relative">
    <div class="card-header p-3">Subscription</div>
    <div class="card-body">
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0"><?php echo $order->title; ?></h6>
                    <small class="text-muted"><?php echo $order->description; ?></small>
                </div>
                <span class="text-muted">$<?php echo $price; ?> / <?php echo $ordertype; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold">Total</span>
                <strong>$<?php echo $price; ?></strong>
            </li>
        </ul>
    </div>

    <input type="text" name="ordertype" class="d-none" value="<?php echo $ordertype; ?>">
    <input type="text" name="orderid" class="d-none" value="<?php echo $order->id; ?>">
    <input type="text" name="action" class="d-none" value="refresh_checkout_page">

    <div class="overlay">
        <div class="loadingdot"></div>
    </div>
</div>