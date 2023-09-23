<style>
    .list-check {
    position: relative;
    list-style: none;
    line-height: 2rem;
    color: #858b97;
}

.list-check .check, 
.list-check .cross, 
.list-check .check-single {
    position: relative;
}

.list-check .check:before, 
.list-check .cross:before, 
.list-check .check-single:before {
    content: "";
    left: -26px;
    top: 8px;
    position: absolute;
    width: 20px;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
}

.list-check li:before {
    font-family: "Line Awesome Free";
    font-size: 1rem;
}

.list-check .check:before {
    content: "\f058";
    color: #fff;
    background: #009688;
}

.list-check .cross:before {
    content: "\f057";
    color: #fff;
    background: #ff0000;
}

.password-strength-checker_input_container{
    position: relative;
}

.form-control{
    background-color: #f1f1f1;
    border: 1px solid #f1f1f1;
    border-radius: 2px;
    box-sizing: border-box;
    font-size: 14px;
    padding: 13px;
    width: 100%;
}

.Password__strength-meter:after, .Password__strength-meter:before {
    content: "";
    height: inherit;
    background: transparent;
    display: block;
    border-color: #fff;
    border-style: solid;
    border-width: 0 5px;
    position: absolute;
    width: 25%;
    z-index: 10;
}

.Password__strength-meter:before {
    left: 25%;
}

.Password__strength-meter:after {
    right: 25%;
}

.Password__strength-meter--fill[data-score="0"] {
    background: darkred;
    width: 20%;
}

.Password__strength-meter--fill[data-score="1"] {
    background: #ff4500;
    width: 40%;
}

.Password__strength-meter--fill[data-score="2"] {
    background: orange;
    width: 60%;
}

.Password__strength-meter--fill[data-score="3"] {
    background: #9acd32;
    width: 80%;
}

.Password__strength-meter--fill[data-score="4"] {
    background: green;
    width: 100%;
}

.Password__strength-meter {
    position: relative;
    height: 3px;
    background: #ddd;
    margin: 10px auto 20px;
    border-radius: 3px;
}

.Password__strength-meter--fill {
    background: transparent;
    height: inherit;
    position: absolute;
    width: 0;
    border-radius: inherit;
    transition: width .5s ease-in-out,background .25s;
}
</style>

<div class="password-strength-checker_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="password-strength-checker_submit_form">
        <div class="form-group">
            <label>Enter Password</label>
            <div class="password-strength-checker_input_container">
                <input class="form-control" name="password" type="text" />
            </div>
            <div class="Password__strength-meter">
                <div class="Password__strength-meter--fill"></div>
            </div>
        </div>

        <div class="form-group">
            <div class="password-strength-checker_report_container mt-3">
                <div class="password-strength-checker_report">
                    <ul class="list-check mb-0">
                        <li class="lower-case cross">Lowercase Letters</li>
                        <li class="upper-case cross">Uppercase Letters</li>
                        <li class="one-number cross">Number (0-9)</li>
                        <li class="one-special-char cross">Special Character (!@#$%^&amp;*)</li>
                        <li class="eight-character cross">Atleast 8 Character</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>