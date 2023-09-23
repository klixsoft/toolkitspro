<style>
.generate-settings-fieldset {
    color: #000;
    font-size: 22px;
    font-weight: 400;
    line-height: 30px;
    border-width: 2px;
    border-style: solid;
    border-color: #ccc;
    border-image: initial;
    border-radius: 4px;
}

legend {
    box-sizing: border-box;
    color: inherit;
    max-width: 100%;
    padding: 0;
    white-space: normal;
    float: inherit;
    width: auto;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    font-size: 1rem;
    padding: 0 6px;
}

fieldset {
    padding: .35em .75em .625em;
}

.single_settings label {
    font-size: 1rem;
    font-weight: normal !important;
}

.form-control,
.form-control:focus{
    background-color: #f1f1f1;
    border: 1px solid #f1f1f1;
}
</style>

<div class="strong-password-generator_content">
    <div class="strong-password-generator_submit_form">
        <div class="form-group strong-password-generator_input_container">
            <label>Generate a Strong Password!</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="password">
                <button class="btn btn-danger position-relative copyPassword" type="button" title="Click to Copy">Copy</button>
                <button class="btn btn-primary generatePassword" type="button">Generate</button>
            </div>
        </div>

        <div class="form-group mt-3">
            <fieldset class="generate-settings-fieldset">
                <legend>Settings</legend>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Password Length</label>
                            <select name="passwordlength" class="passwordlength form-control form-control-sm w-25">
                                <?php
                                    for($i = 5; $i < 64; $i++){
                                        $selected = 16 == $i ? "selected" : "";
                                        echo sprintf('<option value="%d" %s>%d</option>', $i, $selected, $i);
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Begin with Alphabet</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" name="beginalphabet" checked class="ast-switch-input" />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Duplicate Characters</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" checked name="duplicatechar" class="ast-switch-input" />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Sequential Characters(eg. abc, 789)</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" name="nosequencechar" class="ast-switch-input" />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 offset-md-1">
                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Uppercase</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" checked name="uppercase" class="ast-switch-input" />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Lowercase</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" name="lowercase" class="ast-switch-input" checked />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Numbers</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" name="numbers" class="ast-switch-input" checked />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between single_settings">
                            <label>Special Characters</label>
                            <div class="ast-toggle-container mt-1">
                                <label class="ast-small-switch">
                                    <input type="checkbox" name="specialcharacter" class="ast-switch-input" checked />
                                    <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="ast-switch-handle"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>