<style>
#fileInput {
    cursor: pointer !important;
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100%;
}

#jsoneditor {
    height: 250px;
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

.html-decoder_copy.active .modal__actions-button-copied,
.html-decoder_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.html-decoder_copy,
.html-decoder_download {
    color: var(--primary);
}

.html-decoder_copy i,
.html-decoder_download i {
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

.html-decoder_report textarea#html-decoder_result {
    border-radius: 0;
}

#jsoneditor * {
    font-family: monospace !important;
}

i.la-spin{
    display:none;
}

.gettingContent i.las{
    position: absolute;
    top: 30%;
    right: 4%;
    color: var(--primary);
    display:block;
}

.modal__actions {
    position: sticky;
    bottom: 0;
}
</style>

<div class="json-to-xml-converter_content">
    <div class="row mb-3">
        <div class="col-md-12 form-group">
            <label class="form-label">
                Load from URL
            </label>
        </div>
        <div class="col">
            <input class="form-control me-3" type="url" id="urlUpload" placeholder="Enter or Paste URL here">
            <i class="las la-spin la-spinner"></i>
        </div>
        <div class="col-auto">
            <div type="button" class="btn btn-primary position-relative rounded-pill upload-btn">
                <i class="las la-paperclip"></i>
                Upload File <input type="file" accept=".html" id="fileInput">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Enter HTML Code:</label>
        <div id="jsoneditor"></div>
    </div>

    <div class="button-row text-center mt-4 mb-3">
        <button type="button" class="btn btn-primary decodeHTMLCode">Decode HTML Code</button>
    </div>


    <div class="form-group">
        <label>Result</label>
        <div class="html-decoder_report_container">
            <div class="html-decoder_report">
                <textarea id="html-decoder_result" disabled rows="8" class="form-control scrollbar"></textarea>
                <div class="modal__actions">
                    <div class="modal__actions-helper">
                        Decoded HTML Result <code>result.html</code>
                    </div>
                    <div class="footer_button_row">
                        <button type="button" class="modal__actions-button html-decoder_copy">
                            <i class="las la-code"></i>
                            <span>Copy</span>
                            <div class="modal__actions-button-copied js-copied">Copied!</div>
                        </button>

                        <button type="button" class="modal__actions-button html-decoder_download">
                            <i class="las la-download"></i>
                            <span>Download</span>
                            <div class="modal__actions-button-copied js-copied">Downloaded!</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>