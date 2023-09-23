<style>
.result_icon {
    background: var(--primary);
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    border-radius: 100%;
    color: #fff;
}

.overview-row {
    display: flex;
    flex-wrap: wrap;
}

.col-part {
    flex: 0 0 auto;
    width: 50%;
}

.col-full {
    flex: 1 0 0%;
}


.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    justify-content: space-between;
}

.modal__actions-helper code {
    border: 1px solid;
    padding: 2px 4px;
    border-radius: 4px;
}

.modal__actions-button {
    position: relative;
    display: flex;
    align-items: center;
    margin-left: auto;
    padding: 0 12px;
    background: #fff;
    border: 1px solid var(--primary);
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

.url-slug-generator_copy.active .modal__actions-button-copied,
.url-slug-generator_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.url-slug-generator_copy,
.url-slug-generator_download {
    color: var(--primary);
}

.url-slug-generator_copy i,
.url-slug-generator_download i {
    font-size: 18px;
}

.footer_button_row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}
</style>

<div class="url-slug-generator_content">
    <form action="<?php echo get_full_url(); ?>" method="post" class="url-slug-generator_submit_form">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Enter String</label>
                    <div class="url-slug-generator_input_container">
                        <input class="form-control" name="inputstr" type="text" placeholder="Enter or Paste String..."
                            required />
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mt-3">
                <div class="form-group">
                    <label>Separator ( - )</label>
                    <div class="ast-toggle-container">
                        <label class="ast-small-switch">
                            <input type="checkbox" checked name="separatordash" class="ast-switch-input" />
                            <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                            <span class="ast-switch-handle"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mt-3">
                <div class="form-group">
                    <label>Separator ( _ )</label>
                    <div class="ast-toggle-container">
                        <label class="ast-small-switch">
                            <input type="checkbox" name="separatorunderscore" class="ast-switch-input" />
                            <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                            <span class="ast-switch-handle"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mt-3">
                <div class="form-group">
                    <label>Remove Stop Word</label>
                    <div class="ast-toggle-container">
                        <label class="ast-small-switch">
                            <input type="checkbox" name="stopword" class="ast-switch-input" />
                            <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                            <span class="ast-switch-handle"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mt-3">
                <div class="form-group">
                    <label>Remove Numbers</label>
                    <div class="ast-toggle-container">
                        <label class="ast-small-switch">
                            <input type="checkbox" name="numbers" class="ast-switch-input" />
                            <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                            <span class="ast-switch-handle"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-5">
            <label>Result</label>

            <div class="url-slug-generator_report_container">
                <div class="url-slug-generator_report">
                    <textarea id="url-slug-generator_result" disabled rows="4"
                        class="form-control scrollbar"></textarea>
                    <div class="modal__actions">
                        <div class="modal__actions-helper">
                            Your SEO Frendly Slug
                        </div>
                        <div class="footer_button_row">
                            <button type="button" class="modal__actions-button url-slug-generator_copy">
                                <i class="las la-code"></i>
                                <span>Copy</span>
                                <div class="modal__actions-button-copied js-copied">Copied!</div>
                            </button>

                            <button type="button" class="modal__actions-button url-slug-generator_download">
                                <i class="las la-download"></i>
                                <span>Download</span>
                                <div class="modal__actions-button-copied js-copied">Downloaded!</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>