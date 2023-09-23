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

.image-to-base64_copy.active .modal__actions-button-copied,
.image-to-base64_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.image-to-base64_copy,
.image-to-base64_download {
    color: var(--primary);
}

.image-to-base64_copy i,
.image-to-base64_download i {
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
                <label>Upload Image:</label>
                <input class="form-control" type="file" accept="image/*" id="base64Image">
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="form-group">
                <label>Result:</label>
                <div class="image-to-base64_report_container">
                    <div class="image-to-base64_report">
                        <textarea id="image-to-base64_result" disabled rows="8"
                            class="form-control scrollbar rounded-0"></textarea>
                        <div class="modal__actions">
                            <div class="modal__actions-helper">
                                Image base64
                            </div>
                            <div class="footer_button_row">
                                <button type="button" class="modal__actions-button image-to-base64_copy">
                                    <i class="las la-code"></i>
                                    <span>Copy</span>
                                    <div class="modal__actions-button-copied js-copied">Copied!</div>
                                </button>

                                <button title="How to use this in Image Tag and CSS Code?" type="button" class="modal__actions-button image-to-base64_download">
                                    <i class="las la-info-circle"></i>
                                    <span>How to use?</span>
                                    <div class="modal__actions-button-copied js-copied">Downloaded!</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="howToUseModal" tabindex="-1" aria-labelledby="howToUseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="howToUseModalLabel">Instruction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Image Tag:</label>
                    <textarea class="imageTag form-control" rows="4"></textarea>
                </div>

                <div class="form-group mt-3">
                    <label>CSS Code:</label>
                    <textarea class="cssTag form-control" rows="4"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>