<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Click on a word you like if you want to temporarily store it in the box below.
            </div>

            <div class="card-body">
                <?php
                    foreach( $output as $tag ){
                        echo sprintf('<span class="yt_tags">%s</span>', $tag);
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<div class="form-group mt-4">
    <label>Your Word List:</label>

    <textarea id="tags_result" disabled rows="5" class="form-control scrollbar"></textarea>
    <div class="modal__actions">
        <div class="modal__actions-helper">
            Youtube Tags <code>tags.txt</code>
        </div>
        <div class="footer_button_row">
            <button type="button" class="modal__actions-button yt-tags-clear_result">
                <i class="las la-times"></i>
                <span>Clear Favourite</span>
                <div class="modal__actions-button-copied js-copied">Cleared!</div>
            </button>

            <button type="button" class="modal__actions-button yt-tags-formatter_copy">
                <i class="las la-code"></i>
                <span>Copy</span>
                <div class="modal__actions-button-copied js-copied">Copied!</div>
            </button>

            <button type="button" class="modal__actions-button yt-tags-formatter_download">
                <i class="las la-download"></i>
                <span>Download</span>
                <div class="modal__actions-button-copied js-copied">Downloaded!</div>
            </button>
        </div>
    </div>
</div>