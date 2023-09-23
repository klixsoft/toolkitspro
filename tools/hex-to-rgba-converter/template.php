<style>
.hex-to-rgba-converter_content .rgb_font {
    font-size: 16px;
    color: #222;
    width: 60px;
}

.hex-to-rgba-converter_content .rgb_input,
.hex-to-rgba-converter_content .rgb_input:focus {
    width: 72px;
    height: 26px;
    font-size: 14px;
    border: 1px solid #E3E7ED;
    border-radius: 0;
    outline: 0;
    box-shadow: none;
}

.hex-to-rgba-converter_content input.form-range {
    width: calc(100% - 150px);
}

.range_green::-webkit-slider-thumb {
    background: green;
}

.range_green::-moz-range-thumb {
    background: green;
}

.range_green::-ms-thumb {
    background: green;
}

.range_red::-webkit-slider-thumb {
    background: red;
}

.range_red::-moz-range-thumb {
    background: red;
}

.range_red::-ms-thumb {
    background: red;
}

.range_blue::-webkit-slider-thumb {
    background: blue;
}

.range_blue::-moz-range-thumb {
    background: blue;
}

.range_blue::-ms-thumb {
    background: blue;
}

.color_pallate {
    width: 82px;
    height: 98px;
    background-color: rgb(0, 0, 0);
}

.color_options {
    width: calc(100% - 120px);
}

.modal__actions-button {
    position: relative;
    display: flex;
    align-items: center;
    margin-left: auto;
    padding: 0 12px;
    background: #fff;
    border: 1px solid var(--primary);
    color:var(--primary) !important;
    border-radius: 0;
    color: #2A81FB;
    font-size: 11px;
    font-weight: bold;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    overflow: hidden;
    cursor: pointer;
    transition: all 250ms ease-out;
    padding: 5px 12px;
}

.modal__actions-button span {
    margin-left: 6px;
}

.modal__actions-button-copied {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary);
    border: 1px solid var(--primary);
    border-radius: 0;
    color: #fff;
    transform: translateY(105%);
    transition: all 250ms ease-out;
}

.copycolorcode.active .modal__actions-button-copied,
.copycolorcode.active .modal__actions-button-copied {
    transform: translateY(0%);
}

body .main_tool_content .form-group .input-group .form-control{
    box-sizing: inherit;
    border-radius: 0;
    padding: 10px;
    font-size: 15px;
    min-height: 40px;
    width: 1%;
}
</style>

<div class="hex-to-rgba-converter_content">
    <div class="hex-to-rgba-converter_submit_form">

        <div class="form-group mb-4">
            <label>Set color levels (0-255) for red, green, and blue, and Use it:</label>
        </div>

        <div class="form_container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="color_pallate"></div>
                <div class="color_options">
                    <div class="d-flex my-2 rgb_db align-items-center justify-content-between">
                        <div class="d-flex">
                            <span class="rgb_font fw_700 text-right">Red</span>
                            <input class="rgb_input rgb_input_red fw_600 border1 text-center ml-2 mr-3" type="number"
                                min="0" max="255" name="red" value="0">
                        </div>
                        <input type="range" class="form-range range_red" value="0" min="0" max="255">
                    </div>

                    <div class="d-flex my-2 rgb_db align-items-center justify-content-between">
                        <div class="d-flex">
                            <span class="rgb_font fw_700 text-right">Green</span>
                            <input class="rgb_input rgb_input_green fw_600 border1 text-center ml-2 mr-3" type="number"
                                min="0" max="255" name="red" value="0">
                        </div>
                        <input type="range" class="form-range range_green" value="0" min="0" max="255">
                    </div>

                    <div class="d-flex my-2 rgb_db align-items-center justify-content-between">
                        <div class="d-flex">
                            <span class="rgb_font fw_700 text-right">Blue</span>
                            <input class="rgb_input rgb_input_blue fw_600 border1 text-center ml-2 mr-3" type="number"
                                min="0" max="255" name="red" value="0">
                        </div>
                        <input type="range" class="form-range range_blue" value="0" min="0" max="255">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Hex Color</label>
                    <div class="input-group">
                        <input type="text" class="form-control hexcolorcode">
                        <button type="button" class="modal__actions-button copycolorcode">
                            <i class="las la-code"></i>
                            <span>Copy</span>
                            <div class="modal__actions-button-copied js-copied">Copied!</div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>RGB Color</label>
                    <div class="input-group">
                        <input type="text" class="form-control rgbcolorcode">
                        <button type="button" class="modal__actions-button copycolorcode">
                            <i class="las la-code"></i>
                            <span>Copy</span>
                            <div class="modal__actions-button-copied js-copied">Copied!</div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>HSL Color</label>
                    <div class="input-group">
                        <input type="text" class="form-control hslcolorcode">
                        <button type="button" class="modal__actions-button copycolorcode">
                            <i class="las la-code"></i>
                            <span>Copy</span>
                            <div class="modal__actions-button-copied js-copied">Copied!</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>