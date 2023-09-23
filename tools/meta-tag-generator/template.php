<?php
$meta = (object) array(
    "title" => "Meta Tag Generator",
    "desc" => "With Meta Tags you can edit and experiment with your content then preview how your webpage will look on Google, Facebook, Twitter and more!",
    "image" => "https://via.placeholder.com/1500x780",
    "link" => get_full_url()
);
?>

<style>
.search-result-google {
    width: 600px;
}

.search-result-google a {
    display: inline-block;
    color: #1a0dab;
    text-decoration: none;
}

.search-result-google .cite {
    font-size: 14px;
    line-height: 16px;
    letter-spacing: normal;
    color: #006621;
    margin:0;
}

.search-result-google .caret {
    font-size: 10px;
    padding-left: 3px;
    color: #006621;
}

.search-result-google h3 {
    margin: 0;
    margin-top: 4px;
    font-size: 20px;
    line-height: 1.3;
}

.search-result-google>a:hover h3 {
    text-decoration: underline;
}

.search-result-google .result-text {
    margin-top: 3px;
    line-height: 1.57;
    color: #3C4043;
    font-size: 14px;
}

.search-result-google .result-text b {
    color: #52565A;
}

.search-result-facebook {
    border: 1px solid #dadde1;
    width: 500px;
}

.search-result-facebook img {
    width: 100%;
    height: auto;
}

.facebook_content_result {
    padding: 10px 12px;
    color: #1d2129;
    border-top: 1px solid #dadde1;
    background: #f2f3f5;
}

.facebook__domain {
    border-collapse: separate;
    color: #606770;
    direction: ltr;
    display: block;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 12px;
    height: 11px;
    line-height: 11px;
    overflow-x: hidden;
    overflow-y: hidden;
    text-align: left;
    text-overflow: ellipsis;
    text-transform: uppercase;
    user-select: none;
    white-space: nowrap;
    width: 501px;
    word-wrap: break-word;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    -webkit-font-smoothing: antialiased;
}

.card-seo-facebook__content {
    border-collapse: separate;
    color: #4b4f56;
    direction: ltr;
    display: block;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 12px;
    height: 46px;
    line-height: 14.4px;
    max-height: 46px;
    overflow-x: hidden;
    overflow-y: hidden;
    text-align: left;
    user-select: none;
    word-wrap: break-word;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    -webkit-font-smoothing: antialiased;
}

.facebook_main_content {
    border-collapse: separate;
    color: #4b4f56;
    direction: ltr;
    display: block;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 12px;
    height: 46px;
    line-height: 14.4px;
    max-height: 46px;
    overflow-x: hidden;
    overflow-y: hidden;
    text-align: left;
    user-select: none;
    word-wrap: break-word;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    -webkit-font-smoothing: antialiased;
}

.facebook__title {
    margin-top: 5px;
    border-collapse: separate;
    color: #1d2129;
    cursor: pointer;
    direction: ltr;
    display: inline;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 14px;
    font-weight: 600;
    height: auto;
    letter-spacing: normal;
    line-height: 18px;
    text-align: left;
    text-decoration-color: #1d2129;
    text-decoration-line: none;
    text-decoration-style: solid;
    transition-delay: 0s;
    transition-duration: 0.1s;
    transition-property: color;
    transition-timing-function: ease-in-out;
    user-select: none;
    white-space: normal;
    width: auto;
    word-wrap: break-word;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    -webkit-font-smoothing: antialiased;
}

@media only screen and (min-width: 770px) {
    .card-seo-facebook__title {
        font-size: 16px;
        line-height: 20px;
    }
}

.facebook__description {
    border-collapse: separate;
    color: #606770;
    direction: ltr;
    display: -webkit-box;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 14px;
    height: 18px;
    line-height: 20px;
    margin-top: 3px;
    max-height: 80px;
    overflow-x: hidden;
    overflow-y: hidden;
    text-align: left;
    text-overflow: ellipsis;
    user-select: none;
    white-space: normal;
    word-break: break-word;
    word-wrap: break-word;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    -webkit-box-orient: vertical;
    -webkit-font-smoothing: antialiased;
    -webkit-line-clamp: 1;
}

.search-result-twitter img,
.search-result-twitter,
.twitter_content_result {
    border-radius: 0.42857em;
}

.twitter_content_result {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.search-result-twitter img {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.twitter__domain {
    display: block;
    color: #657786;
    text-transform: lowercase;
    line-height: 1.3125;
    letter-spacing: normal;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 14px;
}

.twitter__title {
    display: block;
    margin: 0 0 0.15em;
    font-size: 14px;
    line-height: 18.375px;
    letter-spacing: normal;
    overflow: hidden;
}

.twitter__description {
    display: none;
    height: 2.6em;
    max-height: 2.6em;
    margin-top: 0.32333em;
    line-height: 1.3em;
    letter-spacing: normal;
    word-wrap: break-word;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    font-size: 14px;
}

@media only screen and (min-width: 770px) {
    .twitter__domain {
        margin-top: 0.32333em;
        color: #8899A6;
    }

    .twitter__title {
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 1em;
        font-weight: bold;
        line-height: 1.3em;
        max-height: 1.3em;
    }

    .twitter__description {
        display: block;
        display: -webkit-box;
    }
}

#meta_tag_generator_result {
    border: none;
    padding: 1em;
    background: #EBF1FA;
    border-radius: 10px;
    font-family: monospace, serif;
    resize: none;
    border-bottom-left-radius:0;
    border-bottom-right-radius:0;
}

.modal__actions {
    display: flex;
    align-items: center;
    background: #E0E8F3;
    padding: 12px 24px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
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
    width: 86px;
    height: 32px;
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

.meta_tag_generator_copy.active .modal__actions-button-copied {
    transform: translateY(0%);
}

.meta_tag_generator_copy{
    color:var(--primary);
}

.meta_tag_generator_copy svg g{
    stroke:var(--primary);
}

.meta_tag_generator_content [name=title],
.meta_tag_generator_content [name=description]{
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.meta_tag_generator_content .has_progress .progress{
    border-bottom-left-radius: 5px !important;
    border-bottom-right-radius: 5px !important;
}
</style>

<div class="meta_tag_generator_content">
    <div class="meta_tag_generator_submit_form">
        <div class="row">
            <div class="col-12">
                <div class="form-group has_progress">
                    <label class="mb-1 fw-normal">Site Title</label>
                    <input class="form-control" name="title" placeholder="Site Title (Around 60 characters)..." required />
                    <div class="progress rounded-0">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="form-group has_progress">
                    <label class="mb-1 fw-normal">Site Description</label>
                    <textarea class="form-control" name="description" rows="3" placeholder="Site Description (Around 160 characters)..."
                        required></textarea>
                    <div class="progress rounded-0">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0</div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Featured Image</label>
                    <input class="form-control" name="image" placeholder="Image URL..." />
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">URL</label>
                    <input class="form-control" name="websiteurl" placeholder="URL..." />
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Robots to index Website</label>
                    <select name="robots" class="form-control">
                        <option value="index, follow">Yes</option>
                        <option value="nondex, nofollow">No</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Content Type</label>
                    <select name="contenttype" class="form-control">
                        <option value="text/html; charset=utf-8">UTF-8</option>
                        <option value="text/html; charset=utf-16">UTF-16</option>
                        <option value="text/html; charset=iso-8859-1">ISO-8859-1</option>
                        <option value="text/html; charset=windows-1252">WINDOWS-1252</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="mb-1 fw-normal">Language</label>
                    <select name="language" class="form-control">
                        <option value="">No Language Tag</option>
                        <option value="English">English</option>
                        <option value="French">French</option>
                        <option value="Spanish">Spanish</option>
                        <option value="Russian">Russian</option>
                        <option value="Arabic">Arabic</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Korean">Korean</option>
                        <option value="Hindi">Hindi</option>
                        <option value="Portuguese">Portuguese</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group mt-5">
            <label>Preview</label>

            <div class="meta_tag_generator_report_container mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ast_tabs">
                            <nav>
                                <ul class="nav nav-tabs" id="metaPreview" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="google-tab" data-bs-toggle="tab"
                                            data-bs-target="#google" type="button" role="tab" aria-controls="google"
                                            aria-selected="false">Google</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="facebook-tab" data-bs-toggle="tab"
                                            data-bs-target="#facebook" type="button" role="tab" aria-controls="facebook"
                                            aria-selected="true">Facebook</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="twitter-tab" data-bs-toggle="tab"
                                            data-bs-target="#twitter" type="button" role="tab" aria-controls="twitter"
                                            aria-selected="false">Twitter</button>
                                    </li>
                                </ul>
                            </nav>
                            <div class="tab-content" id="metaPreviewContent">
                                <div class="tab-pane fade active show" id="google" role="tabpanel"
                                    aria-labelledby="google-tab">
                                    <div class="search-result-google mt-3">
                                        <a href="javascript:void(0);">
                                            <h3><?php echo $meta->title; ?></h3>
                                            <p class="cite"><?php echo $_SERVER['SERVER_NAME']; ?> › tool › meta-tag-generator <span
                                                    class="caret">▼</span></p>
                                        </a>
                                        <p class="result-text"><?php echo $meta->desc; ?></p>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="facebook" role="tabpanel" aria-labelledby="facebook-tab">
                                    <div class="search-result-facebook mt-3">
                                        <img src="<?php echo $meta->image; ?>" alt="Image Placeholder">
                                        <div class="facebook_content_result">
                                            <span class="facebook__domain"><?php echo $_SERVER['SERVER_NAME']; ?></span>
                                            <div class="facebook_main_content">
                                                <div style="margin-top:5px">
                                                    <div class="facebook__title"><?php echo $meta->title; ?></div>
                                                </div>
                                                <span class="facebook__description"><?php echo $meta->desc; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="twitter-tab">
                                    <div class="search-result-facebook search-result-twitter mt-3">
                                        <img src="<?php echo $meta->image; ?>"
                                            alt="Image Placeholder">
                                        <div class="twitter_content_result facebook_content_result">
                                            <div class="twitter_main_content">
                                                <div style="margin-top:5px">
                                                    <div class="twitter__title"><?php echo $meta->title; ?></div>
                                                </div>
                                                <span class="twitter__description"><?php echo $meta->desc; ?></span>
                                            </div>
                                            <span class="twitter__domain"><?php echo $_SERVER['SERVER_NAME']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <label>Result</label>
            <div class="meta_tag_generator_report_container">
                <div class="meta_tag_generator_report">
                    <textarea id="meta_tag_generator_result" disabled rows="23" class="form-control scrollbar"></textarea>
                    <div class="modal__actions">
                        <div class="modal__actions-helper">
                            Copy the code into your website <code>&lt;head&gt;</code>
                        </div>
                        <button type="button" class="modal__actions-button meta_tag_generator_copy">
                            <svg width="20" height="15" viewBox="0 0 20 15" xmlns="http://www.w3.org/2000/svg">
                                <g stroke="#2A81FB" stroke-width="2" fill="none" fill-rule="evenodd"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M5.744 2.857L1 7.732l4.696 4.953M14.304 2.857L19 7.81l-4.696 4.952M11.957 1L8 14">
                                    </path>
                                </g>
                            </svg>
                            <span>Copy</span>
                            <div class="modal__actions-button-copied js-copied">Copied!</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>