<style>
.pricing-section .section-title {
    position: relative;
}

.pricing-section .section-title.title-ex1 h2:before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 12px;
    width: 110px;
    height: 1px;
    background-color: #d6dbe2;
    margin-bottom: 15px;
}

@media (min-width: 768px) {
    .pricing-section .section-title.title-ex1 h2:before {
        bottom: 17px;
    }
}

@media (min-width: 992px) {
    .pricing-section .section-title.title-ex1 h2:before {
        bottom: 25px;
    }
}

.pricing-section .section-title.title-ex1 h2:after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 12px;
    width: 40px;
    height: 1px;
    background-color: var(--primary);
    margin-bottom: 15px;
}

@media (min-width: 768px) {
    .pricing-section .section-title.title-ex1 h2:after {
        bottom: 17px;
    }
}

@media (min-width: 992px) {
    .pricing-section .section-title.title-ex1 h2:after {
        bottom: 25px;
    }
}

.pricing-section .section-title.title-ex1.text-center h2:before {
    left: 50%;
    transform: translateX(-50%);
}

.pricing-section .section-title.title-ex1.text-center h2:after {
    left: 50%;
    transform: translateX(-50%);
}

.pricing-section .section-title.title-ex1.text-right h2:before {
    left: auto;
    right: 0;
}

.pricing-section .section-title.title-ex1.text-right h2:after {
    left: auto;
    right: 0;
}

.pricing-section .price-card {
    background: #f5f5f6;
    padding: 40px 35px;
    position: relative;
    border-radius: 2px;
    overflow: hidden;
}

.pricing-section .price-card:before {
    position: absolute;
    content: "";
    top: 0;
    right: -35px;
    width: 88px;
    height: 88px;
    background: var(--primary);
    opacity: 0.2;
    border-radius: 8px;
    transform: rotate(45deg);
}

.pricing-section .price-card:after {
    position: absolute;
    content: "";
    top: 30px;
    right: -35px;
    width: 88px;
    height: 88px;
    background: var(--primary);
    opacity: 0.2;
    border-radius: 8px;
    transform: rotate(45deg);
}

.pricing-section .price-card h2 {
    font-size: 26px;
    font-weight: 600;
}

.pricing-section .price-card.featured {
    background: #fff;
    border: 1px solid #ebebeb;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.pricing-section .price-card:hover .btn {
    background: var(--primary);
    border-color: var(--primary);
}

.pricing-section p.price span {
    display: inline-block;
    padding: 15px;
    padding-right: 0;
    font-size: 50px;
    font-weight: 600;
    color: var(--primary);
    position: relative;
}

.pricing-section p.price span:before {
    position: absolute;
    content: "$";
    font-size: 16px;
    top: 25px;
    font-weight: 300;
    left: 0;
}

.pricing-section .pricing-offers {
    padding: 0 0 10px;
}

.pricing-section .pricing-offers li {
    padding: 0 0 16px;
    line-height: 18px;
}

.pricing-switcher .fieldset {
    display: inline-block;
    position: relative;
    padding: 0 !important;
    border-radius: 5px;
    border: 2px solid var(--primary);
    background: #fff;
}

.pricing-switcher input[type="radio"] {
    position: absolute;
    opacity: 0
}

.pricing-switcher label {
    position: relative;
    z-index: 1;
    display: inline-block;
    float: left;
    width: 100px;
    height: 36px;
    line-height: 30px;
    cursor: pointer;
    font-size: 1rem;
    margin: 0 !important;
    padding: 3px;
    text-align: center
}

.pricing-switcher label span {
    display: block;
    line-height: normal;
    font: caption;
    font-size: smaller
}

.pricing-switcher .switch {
    position: absolute;
    top: 0;
    left: 0;
    width: 100px;
    height: 36px;
    background-color: var(--primary);
    color: #fff;
    -webkit-transition: -webkit-transform .5s;
    -moz-transition: -moz-transform .5s;
    transition: transform .5s
}

.pricing-switcher input[type="radio"]:checked+label+.switch,
.pricing-switcher input[type="radio"]:checked+label:nth-of-type(n)+.switch {
    -webkit-transform: translateX(100px);
    -moz-transform: translateX(100px);
    -ms-transform: translateX(100px);
    -o-transform: translateX(100px);
    transform: translateX(100px)
}

.pricing-switcher input[type="radio"]:checked+label {
    color: #fff
}

@keyframes shake {
    0% {
        transform: translate(1px, 1px) rotate(0deg);
    }

    10% {
        transform: translate(-1px, -2px) rotate(-1deg);
    }

    20% {
        transform: translate(-3px, 0px) rotate(1deg);
    }

    30% {
        transform: translate(3px, 2px) rotate(0deg);
    }

    40% {
        transform: translate(1px, -1px) rotate(1deg);
    }

    50% {
        transform: translate(-1px, 2px) rotate(-1deg);
    }

    60% {
        transform: translate(-3px, 1px) rotate(0deg);
    }

    70% {
        transform: translate(3px, 1px) rotate(-1deg);
    }

    80% {
        transform: translate(-1px, -1px) rotate(1deg);
    }

    90% {
        transform: translate(1px, 2px) rotate(0deg);
    }

    100% {
        transform: translate(1px, -2px) rotate(-1deg);
    }
}

.pricing-switcher .fieldset::after {
    content: '';
    background: #0000 url(https://www.prepostseo.com/imgs/off-label.png) no-repeat center;
    height: 90px;
    display: block;
    position: absolute;
    right: -105px;
    width: 112px;
    top: -25px;
    z-index: -1;
    animation: shake 5s;
    animation-iteration-count: infinite;
}
</style>

<?php
global $db;
$db->where("type=? AND extra=?", array("plan", "plan"));
$plans = $db->objectBuilder()->get("posts");
?>

<section class="pricing-section py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="section-title text-center title-ex1 mb-5">
                    <h2 class="py-3">Pricing</h2>
                    <p>Choose your plans. Get with awesome discounts.</p>
                </div>
            </div>
        </div>
        <!-- Pricing Table starts -->
        <div class="row">
            <div class="col-12">
                <div class="pricing-switcher text-center mb-4">
                    <p class="fieldset">
                        <input type="radio" name="planChange" value="monthly" id="monthly-plan" checked="">
                        <label class="label-monthly bg-dark-mode" for="monthly-plan">Monthly</label>
                        <input type="radio" name="planChange" value="yearly" id="yearly-plan">
                        <label class="label-yearly" for="yearly-plan">Annually</label>
                        <span class="switch"></span>
                    </p>
                </div>
            </div>

            <?php 
            foreach($plans as $key => $plan):
                $meta = get_all_meta("plan", $plan->id);
            ?>
            <div class="col-md-4">
                <div class="price-card <?php echo $key == 1 ? 'featured' : ''; ?>">
                    <h2><?php echo $plan->title; ?></h2>
                    <p><?php echo $plan->description; ?></p>

                    <p class="price monthly"><span><?php echo $meta->monthlyprice; ?></span>/ Month</p>
                    <p class="price yearly d-none"><span><?php echo $meta->yearlyprice; ?></span>/ Yearly</p>

                    <ul class="pricing-offers">
                        <li>Upload File size upto <?php echo $meta->filesize; ?>MB</li>
                        <li>Can upload upto <?php echo $meta->imagenum; ?> files</li>
                        <li>Can upload upto <?php echo $meta->urlnums; ?> URLS</li>
                        <li>API Access</li>
                        <li>Monthly <?php echo $meta->dailyusage; ?> API Requests</li>
                    </ul>
                    <button type="button" class="btn btn-primary w-100 subscribePlan" data-plan="<?php echo $plan->id; ?>">Subscribe</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>