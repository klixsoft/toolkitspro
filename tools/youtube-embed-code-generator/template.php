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
    color: var(--primary);
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

.yt_embed_link_copy.active .modal__actions-button-copied,
.yt_embed_link_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.yt_embed_link_copy,
.yt_embed_link_download {
    color: var(--primary);
}

.yt_embed_link_copy i,
.yt_embed_link_download i {
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

.modal__actions{
    position: sticky;
    bottom:0;
}
</style>

<div class="youtube-embed-code-generator_content">
    <div class="form-group">
        <label>Enter YouTube Video URL</label>
        <input type="url" name="url" class="form-control inputchange" placeholder="https:// . . . ">
    </div>

    <div class="form-group mt-4 form-group-nopad">
        <label>Size</label>
        <em class="mb-1 d-block">Leave blank if you do not want to specify. Default: 560x315</em>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Width</span>
            </div>
            <input type="number" name="width" class="form-control inputchange" value="560" placeholder="Width">

            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Height</span>
            </div>
            <input type="number" name="height" class="form-control inputchange" value="315" placeholder="Width">
        </div>
    </div>

    <div class="form-group mt-4 form-group-nopad">
        <label>Start Time</label>
        <em class="mb-1 d-block">Leave blank if you do not want to specify</em>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Minutes</span>
            </div>
            <input type="number" name="sminute" class="form-control inputchange" placeholder="Minutes">

            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Seconds</span>
            </div>
            <input type="number" name="sseconds" class="form-control inputchange" placeholder="Seconds">
        </div>
    </div>

    <div class="form-group mt-4 form-group-nopad">
        <label>Ends Time</label>
        <em class="mb-1 d-block">Leave blank if you do not want to specify</em>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Minutes</span>
            </div>
            <input type="number" name="eminute" class="form-control inputchange" placeholder="Minutes">

            <div class="input-group-prepend">
                <span class="input-group-text" style="background:#e9ecef;">Seconds</span>
            </div>
            <input type="number" name="eseconds" class="form-control inputchange" placeholder="Seconds">
        </div>
    </div>

    <h3 class="title_back mt-3 w-100 text-center">More Options</h3>

    <div class="row">
        <div class="col-md-6 col-12 mt-3">
            <div class="from-group">
                <label>Loop video</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="loop" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12 mt-3">
            <div class="from-group">
                <label>Auto play video</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="autoplay" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12 mt-3">
            <div class="from-group">
                <label>Hide Full-screen button</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="hidefullscr" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-12 mt-3">
            <div class="from-group">
                <label>Hide player controls</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="hideplayerctr" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-12 mt-3">
            <div class="from-group">
                <label>Hide YouTube logo</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="hideytlogo" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="from-group">
                <label>Privacy enhanced (only cookie when user starts video)</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="privacy" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>


        <div class="col-md-6 mt-3">
            <div class="from-group">
                <label>Responsive (auto scale to available width)</label>
                <div class="ast-toggle-container mt-1">
                    <label class="ast-small-switch">
                        <input type="checkbox" name="responsive" class="ast-switch-input inputchange" />
                        <span class="ast-switch-label" data-on="Yes" data-off="No"></span>
                        <span class="ast-switch-handle"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="button-group text-center mt-4">
        <button class="btn btn-primary" type="button" id="generate_embeded_code">Generate Embeded Code</button>
    </div>

    <div class="form-group mt-5">
        <label>HTML Embed Link:</label>

        <textarea id="yt_embed_link" disabled rows="5" class="form-control scrollbar"></textarea>
        <div class="modal__actions">
            <div class="modal__actions-helper">
                Youtube Embed Link:
            </div>
            <div class="footer_button_row">
                <button type="button" class="modal__actions-button yt_embed_link_copy">
                    <i class="las la-code"></i>
                    <span>Copy</span>
                    <div class="modal__actions-button-copied js-copied">Copied!</div>
                </button>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <label>Preview:</label>

        <div id="yt_embed_preview"></div>
    </div>
</div>