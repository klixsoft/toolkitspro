<style>
.yt_tags{
    background: #ebebeb;
    padding: 5px 10px;
    border-radius: 3px;
    margin-right: 10px;
    margin-bottom: 10px;
    display: inline-block;
    cursor: pointer;
}

.youtube-hashtag-extractor_report .card{
    border-radius:0;
}

.youtube-hashtag-extractor_report .card-body{
    padding: 1rem;
    font-weight: bold;
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

.yt-tags-formatter_copy.active .modal__actions-button-copied,
.yt-tags-formatter_download.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.yt-tags-formatter_copy,
.yt-tags-formatter_download {
    color: var(--primary);
}

.yt-tags-formatter_copy i,
.yt-tags-formatter_download i {
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
</style>

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