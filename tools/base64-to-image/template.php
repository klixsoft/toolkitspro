<style>
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

.base64-to-image_copy.active .modal__actions-button-copied,
.base64-to-image_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.base64-to-image_copy,
.base64-to-image_download {
    color: var(--primary);
}

.base64-to-image_copy i,
.base64-to-image_download i {
    font-size: 18px;
}

.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    justify-content: space-between;
}

.footer_button_row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}

.modal__actions {
    position: sticky;
    bottom: 0;
}
</style>

<div class="image_to_base64_content">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Base64 Image:</label>
                <div class="base64-to-image_report_container">
                    <div class="base64-to-image_report">
                        <textarea id="base64-to-image_result" rows="8"
                            class="form-control scrollbar rounded-0"></textarea>
                        <div class="modal__actions">
                            <div class="modal__actions-helper">
                                Paste Base64 Image Code
                            </div>
                            <div class="footer_button_row">
                                <button type="button" class="modal__actions-button base64-to-image_copy">
                                    <i class="las la-code"></i>
                                    <span>Copy</span>
                                    <div class="modal__actions-button-copied js-copied">Copied!</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="image_output d-none">
                    <label class="mt-4">Image Output:</label>
                    <div class="button-row">
                        <a href="" download class="downloadImageLink btn btn-primary" rel="noopener noreferrer">Download Image</a>
                    </div>
                    <div class="image_output_container mt-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>