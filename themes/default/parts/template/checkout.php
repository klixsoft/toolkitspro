<style>
.custom-radio-checkbox .radio-checkbox-wrapper {
    width: 100%;
    margin-bottom: .5rem
}

.custom-radio-checkbox .radio-checkbox-input {
    opacity: 0;
    visibility: hidden;
    margin: 0;
    position: absolute
}

.custom-radio-checkbox .radio-checkbox-input:checked+.radio-checkbox-tile {
    background: var(--primary)
}

.custom-radio-checkbox .radio-checkbox-input:checked+.radio-checkbox-tile span {
    border-color: var(--bs-border-color);
    color: #fff
}

.custom-radio-checkbox .radio-checkbox-input:checked+.radio-checkbox-tile i,
.custom-radio-checkbox .radio-checkbox-input:checked+.radio-checkbox-tile svg {
    color: #fff !important;
    fill: #fff !important
}

.custom-radio-checkbox .radio-checkbox-input:checked+.radio-checkbox-tile:before {
    transform: scale(1);
    opacity: 1
}

.custom-radio-checkbox .radio-checkbox-tile {
    display: flex;
    align-items: center;
    padding-left: 15px;
    gap: .2rem;
    width: 95%;
    height: 50px;
    border-radius: 5px;
    border: 1px solid var(--bs-border-color);
    transition: .1s ease;
    cursor: pointer;
    position: relative
}

.custom-radio-checkbox .radio-checkbox-tile i,
.custom-radio-checkbox .radio-checkbox-tile svg {
    color: #adb5bd !important;
    fill: #adb5bd !important;
    margin-right: 10px
}

[dir=rtl] .custom-radio-checkbox .radio-checkbox-tile {
    padding-left: 0;
    padding-right: 15px !important
}

@media(max-width: 1199.98px) {
    .custom-radio-checkbox .radio-checkbox-tile {
        width: 100% !important
    }
}

.custom-radio-checkbox .radio-checkbox-tile:hover {
    border-color: var(--bs-border-color)
}

.custom-radio-checkbox .radio-checkbox-tile:before {
    font-size: 12px;
    text-align: center;
    position: absolute;
    display: block;
    width: 1.5rem;
    height: 1.5rem;
    background-color: var(--primary) !important;
    border-radius: 50%;
    right: -11px;
    opacity: 0;
    transform: scale(0);
    transition: .25s ease;
    content: "✔";
    color: #fff;
    border: 2px solid #fff;
    background-size: 12px;
    background-repeat: no-repeat;
    background-position: 50% 50%
}

.custom-radio-checkbox {
    margin-bottom: 5px;
}
</style>

<div class="beadcrum textture_background py-3">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1>Checkout</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="checkout_page pt-4">
    <div class="container">
        <form action="<?php echo get_full_url(true); ?>" method="post" class="checkout">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-box">
                        <div class="card-header p-3">Billing Details</div>
                        <div class="card-body">
                            <div class="checkout_form">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" value="<?php echo $user->name; ?>" name="name"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mt-3">
                                            <label>Email</label>
                                            <input type="text" name="email" value="<?php echo $user->email; ?>"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mt-3">
                                            <label>Company Name</label>
                                            <input type="text" value="" name="company" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mt-3">
                                            <label>Street Address</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" name="address1" class="form-control">
                                                </div>

                                                <div class="col-sm-6">
                                                    <input type="text" name="address2" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mt-3">
                                            <label>Country</label>
                                            <input type="text" name="country" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mt-3">
                                            <label>Postal Code</label>
                                            <input type="text" name="postcode" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="overviewcard">
                        <?php
                            /**
                             * Include order overview
                             */
                            do_action("tkp/checkout/overview", $order, $ordertype);
                        ?>
                    </div>

                    <div class="paymentscard mt-3">
                        <?php
                            /**
                             * Include supported payments
                             */
                            do_action("tkp/checkout/payments", "paypal", $order, $ordertype);
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>