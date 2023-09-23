<style>
#robots_txt_generator_result {
    border: none;
    padding: 1em;
    background: #EBF1FA;
    border-radius: 10px;
    font-family: monospace, serif;
    resize: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
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

.robots_txt_generator_copy.active .modal__actions-button-copied,
.robots_txt_generator_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.robots_txt_generator_copy,
.robots_txt_generator_download {
    color: var(--primary);
}

.robots_txt_generator_copy i,
.robots_txt_generator_download i {
    font-size: 18px;
}

.footer_button_row{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:5px;
}
</style>

<div class="backlink_maker_content">
    <div class="backlink_maker_submit_form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Default - All Robots are</label>
                    <div class="backlink_maker_input_container">
                        <select class="form-control" name="allow">
                            <option value=" " selected="selected">Allowed</option>
                            <option value="/">Refused</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Crawl-Delay</label>
                    <div class="backlink_maker_input_container">
                        <select class="form-control" name="delay">
                            <option value="default">Default - No Delay</option>
                            <option value="5">5 Seconds</option>
                            <option value="10">10 Seconds</option>
                            <option value="20">20 Seconds</option>
                            <option value="60">60 Seconds</option>
                            <option value="120">120 Seconds</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Sitemap URL</label>
                    <div class="backlink_maker_input_container">
                        <input type="url" name="sitemap" class="form-control"
                            placeholder="Leave blank if you don't have">
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <strong>Search Robots:</strong>

                <div class="row search_robots_containers">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Google</label>
                            <div class="backlink_maker_input_container">
                                <select name="google" data-agent="Googlebot" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Google Image</label>
                            <div class="backlink_maker_input_container">
                                <select name="gimage" data-agent="googlebot-image" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Google Mobile</label>
                            <div class="backlink_maker_input_container">
                                <select name="googleMobile" data-agent="googlebot-mobile" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">MSN</label>
                            <div class="backlink_maker_input_container">
                                <select name="msn" data-agent="MSNBot" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Yahoo</label>
                            <div class="backlink_maker_input_container">
                                <select name="yahoo" data-agent="Slurp" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Yahoo MM</label>
                            <div class="backlink_maker_input_container">
                                <select name="uahoomm" data-agent="yahoo-mmcrawler" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Yahoo Blogs</label>
                            <div class="backlink_maker_input_container">
                                <select name="yahooblogs" data-agent="yahoo-blogs/v3.9" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Ask/Teoma</label>
                            <div class="backlink_maker_input_container">
                                <select name="teoma" data-agent="Teoma" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">DMOZ Checker</label>
                            <div class="backlink_maker_input_container">
                                <select name="dmoz" data-agent="Robozilla" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Nutch</label>
                            <div class="backlink_maker_input_container">
                                <select name="nutch" data-agent="Nutch" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Alexa/Wayback</label>
                            <div class="backlink_maker_input_container">
                                <select name="alexa" data-agent="ia_archiver" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Baidu</label>
                            <div class="backlink_maker_input_container">
                                <select name="baidu" data-agent="baiduspider" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">Naver</label>
                            <div class="backlink_maker_input_container">
                                <select name="naver" data-agent="naverbot" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                        <div class="form-group">
                            <label class="mb-1 fw-normal">MSN PicSearch</label>
                            <div class="backlink_maker_input_container">
                                <select name="msnpicsearch" data-agent="psbot" class="form-control">
                                    <option value="default">Default</option>
                                    <option value="allow">Allowed</option>
                                    <option value="refuse">Refused</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <strong class="d-block">Restricted Directories</strong>
                <small><i>The path is relative to root and must contain a trailing slash "/"</i></small>

                <div class="row mt-3 directory_template_container">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" value="/cgi-bin/">
                        </div>
                    </div>
                </div>

                <div class="button-row text-center mt-3">
                    <button class="btn btn-primary add_new_directory_row text-white"><i class="las la-plus"></i> Add New
                        Directory</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Result</label>
            <div class="robots_txt_generator_report_container">
                <div class="robots_txt_generator_report">
                    <textarea id="robots_txt_generator_result" disabled rows="10"
                        class="form-control scrollbar">User-agent: *
Disallow:
Disallow: /cgi-bin/
</textarea>
                    <div class="modal__actions">
                        <div class="modal__actions-helper">
                            Upload the file in root project <code>robots.txt</code>
                        </div>
                        <div class="footer_button_row">
                            <button type="button" class="modal__actions-button robots_txt_generator_copy">
                                <i class="las la-code"></i>
                                <span>Copy</span>
                                <div class="modal__actions-button-copied js-copied">Copied!</div>
                            </button>

                            <button type="button" class="modal__actions-button robots_txt_generator_download">
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
</div>