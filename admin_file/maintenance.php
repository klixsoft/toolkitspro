<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website is under Maintenance!!!</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
    * {
        font-family: sans-serif;
    }

    body {
        background: #7918f2;
        background: -webkit-linear-gradient(-45deg, #ac32e4, #7918f2, #4801ff);
        background: -o-linear-gradient(-45deg, #ac32e4, #7918f2, #4801ff);
        background: -moz-linear-gradient(-45deg, #ac32e4, #7918f2, #4801ff);
        background: linear-gradient(-45deg, #ac32e4, #7918f2, #4801ff);
        height: 100vh;
        overflow: hidden;
    }

    h3 {
        font-size: 50px;
        color: #fff;
        line-height: 1.2;
        text-transform: uppercase;
        text-align: center;
    }

    .desc {
        font-size: 30px;
        color: #fff;
        line-height: 1.2;
    }

    .countdown_single {
        background-color: #fff;
        border-radius: 18px;
        width: 90px;
        height: 90px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .countdown {
        gap: 18px;
    }

    .countdown_single span {
        display: block;
    }

    .countdown_single .timer {
        font-size: 36px;
        color: #000;
        line-height: 1;
        padding-bottom: 9px;
        font-weight: bold;
    }

    .countdown_single .label {
        font-size: 12px;
        color: #7d8da6;
        line-height: 1;
        text-transform: uppercase;
    }

    .maintenance_content {
        max-width: 600px;
        margin: 0 auto;
        text-align: Center;
    }

    .copyright {
        font-size: 12px;
        color: #ccc;
        line-height: 1.4;
    }

    .contactbtn,
    .contactbtn:hover {
        padding: 10px 20px;
        background-color: transparent;
        border-radius: 25px;
        border: 2px solid #fff;
        position: relative;
        z-index: 1;
        overflow: hidden;

        min-width: 280px;
        max-width: 100%;
        min-height: 50px;

        font-size: 15px;
        color: #fff;
        line-height: 1.2;

        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="maintenance">
        <div class="container">
            <div class="maintenance_content mt-5">
                <h3><?php echo @$maintenance->title; ?></h3>
                <div class="desc my-5"><?php echo @$maintenance->message; ?></div>

                <?php if( !empty( @$maintenance->upto ) ): ?>
                <div class="countdown my-5 d-flex align-items-center justify-content-center">
                    <div class="countdown_single">
                        <span class="timer" id="days_timer">0</span>
                        <span class="label">Days</span>
                    </div>

                    <div class="countdown_single">
                        <span class="timer" id="hours_timer">0</span>
                        <span class="label">Hours</span>
                    </div>

                    <div class="countdown_single">
                        <span class="timer" id="minutes_timer">0</span>
                        <span class="label">Minutes</span>
                    </div>

                    <div class="countdown_single">
                        <span class="timer" id="seconds_timer">0</span>
                        <span class="label">Seconds</span>
                    </div>
                </div>

                <script>
                var countDownDate = new Date("<?php echo $maintenance->upto; ?>").getTime();
                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("seconds_timer").innerHTML = seconds;
                    document.getElementById("minutes_timer").innerHTML = minutes;
                    document.getElementById("hours_timer").innerHTML = hours;
                    document.getElementById("days_timer").innerHTML = days;

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(x);

                        document.getElementById("seconds_timer").innerHTML = "0";
                        document.getElementById("minutes_timer").innerHTML = "0";
                        document.getElementById("hours_timer").innerHTML = "0";
                        document.getElementById("days_timer").innerHTML = "0";
                    }
                }, 1000);
                </script>
                <?php endif; ?>

                <div class="btn_container my-5">
                    <a class="contactbtn"
                        href="<?php echo @$maintenance->btnlink; ?>"><?php echo @$maintenance->btntext; ?></a>
                </div>

                <p class="copyright">Copyright <?php echo date("Y"); ?> | All Right Reserved</p>
            </div>
        </div>
    </div>
</body>

</html>