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

.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    justify-content:space-between;
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

.whois_checker_copy.active .modal__actions-button-copied,
.whois_checker_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.whois_checker_copy,
.whois_checker_download {
    color: var(--primary);
}

.whois_checker_copy i,
.whois_checker_download i {
    font-size: 18px;
}

.footer_button_row{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:5px;
}
</style>

<div class="whois_checker_content">
    <div class="whois_checker_submit_form">
        <div class="form-group">
            <label>Enter URL:</label>
            <div class="whois_checker_input_container">
                <textarea class="form-control" id="url_encode_url_text" rows="3" placeholder="Enter or Paste url..." required></textarea>
            </div>
        </div>

        <div class="button-row text-center my-4">
            <button type="button" id="encode_url_btn" class="btn btn-primary text-white">Encode URL</button>
            <button type="button" id="decode_url_btn" class="btn btn-danger">Decode URL</button>
        </div>

        <div class="form-group">
            <label>Result</label>

            <div class="whois_checker_report_container">
                <div class="whois_checker_report">
                    <div class="whois_checker_report_container">
                        <div class="whois_checker_report">
                            <textarea id="url-encoder-decoder_result" disabled rows="3"
                                class="form-control scrollbar"></textarea>
                            <div class="modal__actions">
                                <div class="modal__actions-helper">
                                    Result for URL Encoder / Decoder
                                </div>
                                <div class="footer_button_row">
                                    <button type="button" class="modal__actions-button whois_checker_copy">
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
        </div>
    </div>
</div>