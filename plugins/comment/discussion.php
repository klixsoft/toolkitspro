<?php
$dark = is_dark_theme();

$starIcon = get_site_url(sprintf("plugins/comment/assets/img/star%s.svg", $dark ? '-dark' : ''));
$starAllIcon = get_site_url(sprintf("plugins/comment/assets/img/grey-star%s.svg", $dark ? '-dark' : ''));
?>
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="discussion_container mt-0">
    <div class="row">
        <div class="col-12">
            <?php if( $enableReview ): ?>
            <h4 class="discssion_title">Rating Overview</h4>
            <div class="row rating_overview mt-3 mb-5">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="rating-number"><span id="rating_overview">0</span><small>/5</small></div>
                        <div class="rating-stars d-inline-block position-relative mr-2">
                            <img src="<?php echo $starAllIcon; ?>" alt="Five Star Rating">
                            <div class="filled-star" style="width:0%"></div>
                        </div>
                        <div class="text-muted totalrating_count">0 ratings</div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="rating-divided">
                        <div class="rating-progress five">
                            <span class="rating-grade">5 <img src="<?php echo $starIcon; ?>" alt="Star"></span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="rating-value">0</span>
                        </div>
                        <div class="rating-progress four">
                            <span class="rating-grade">4 <img src="<?php echo $starIcon; ?>" alt="Star"></span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="rating-value">0</span>
                        </div>
                        <div class="rating-progress three">
                            <span class="rating-grade">3 <img src="<?php echo $starIcon; ?>" alt="Star"></span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="rating-value">0</span>
                        </div>
                        <div class="rating-progress two">
                            <span class="rating-grade">2 <img src="<?php echo $starIcon; ?>" alt="Star"></span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="rating-value">0</span>
                        </div>
                        <div class="rating-progress one">
                            <span class="rating-grade">1 <img src="<?php echo $starIcon; ?>" alt="Star"></span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="rating-value">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <h4 class="discssion_title">Discussion</h4>
            <?php endif; ?>

            <script>
            let permanentPostId = <?php echo $postID; ?>;
            </script>

            <div class="discussion_form">
                <input id="comment_id" type="hidden" value="<?php echo $postID; ?>" />
                <input id="parent_comment_id" type="hidden" value="0" />
                <?php if(is_user_loggin()): ?>
                <div class="custom_editor">
                    <div id="editor"></div>

                    <?php if( $enableReview ): ?>
                    <div class="commentRating">
                        <input aria-labelledby="commentstart5" type="radio" id="star5" name="rating" value="5">
                        <label aria-label="5 Star" id="commentstart5" for="star5">&nbsp;</label>
                        <input aria-labelledby="commentstart4" type="radio" id="star4" name="rating" value="4">
                        <label aria-label="4 Star" id="commentstart4" for="star4">&nbsp;</label>
                        <input aria-labelledby="commentstart3" type="radio" id="star3" name="rating" value="3">
                        <label aria-label="3 Star" id="commentstart3" for="star3">&nbsp;</label>
                        <input aria-labelledby="commentstart2" type="radio" id="star2" name="rating" value="2">
                        <label aria-label="2 Star" id="commentstart2" for="star2">&nbsp;</label>
                        <input aria-labelledby="commentstart1" type="radio" id="star1" name="rating" value="1">
                        <label aria-label="1 Star" id="commentstart1" for="star1">&nbsp;</label>
                    </div>
                    <?php endif; ?>

                    <script>
                    var labels = document.querySelectorAll('.commentRating label');
                    labels.forEach(function(label) {
                        label.addEventListener('click', function(event) {
                            event.preventDefault();
                            var input = document.getElementById(label.getAttribute('for'));
                            input.checked = true;
                        });
                    });
                    </script>

                    <div id="toolbar">
                        <button title="Bold" class="ql-bold"></button>
                        <button title="Italic" class="ql-italic"></button>
                        <button title="Underline" class="ql-underline"></button>
                        <button title="Strike" class="ql-strike"></button>
                        <button title="Strike" class="ql-script" value="sub"></button>
                        <button title="Strike" class="ql-script" value="super"></button>
                        <button title="Ordered List" class="ql-list" value='ordered'></button>
                        <button title="Unordered List" class="ql-list" value='bullet'></button>
                        <button title="Blockquote" class="ql-blockquote"></button>
                        <button title="Code Block" class="ql-code-block"></button>


                        <div class="hamrocsit-editor-buttons-right float-end">
                            <button type="button" class="submitButton">Submit Message</button>
                            <button type="button" class="replyCloseContainer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path
                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="discussion_error">
                    <div class="alert alert-warning" role="alert">You must login to submit your review. Click <a href="<?php echo get_site_url("auth/login/"); ?>">here</a> to login.</div>
                </div>
                <?php endif; ?>
            </div>

            <div class="discussion_messages_container pb-4">
                <div class="hamrocsit-thread-head">
                    <div class="hamrocsit-thread-info">
                        <span class="hamrocs_comment_count" title="0">0</span> Comments
                    </div>
                    <div class="hamrocsit-space"></div>
                    <div class="hamrocsit-thread-filter">
                        <input type="hidden" class="hamrocsit_filter_value" value="1" />
                        <div class="hamrocsit-filter hamrocsit-reacted" title="Recent Comments">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M151.6 42.4C145.5 35.8 137 32 128 32s-17.5 3.8-23.6 10.4l-88 96c-11.9 13-11.1 33.3 2 45.2s33.3 11.1 45.2-2L96 146.3V448c0 17.7 14.3 32 32 32s32-14.3 32-32V146.3l32.4 35.4c11.9 13 32.2 13.9 45.2 2s13.9-32.2 2-45.2l-88-96zM320 480h32c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128H544c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32z" />
                            </svg>
                        </div>
                        <div class="hamrocsit-filter hamrocsit-hottest active" title="Oldest Comments">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M151.6 42.4C145.5 35.8 137 32 128 32s-17.5 3.8-23.6 10.4l-88 96c-11.9 13-11.1 33.3 2 45.2s33.3 11.1 45.2-2L96 146.3V448c0 17.7 14.3 32 32 32s32-14.3 32-32V146.3l32.4 35.4c11.9 13 32.2 13.9 45.2 2s13.9-32.2 2-45.2l-88-96zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h32c17.7 0 32-14.3 32-32s-14.3-32-32-32H320zm0 128c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H320zm0 128c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H320zm0 128c-17.7 0-32 14.3-32 32s14.3 32 32 32H544c17.7 0 32-14.3 32-32s-14.3-32-32-32H320z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="comments-container">
                    <div class="comment_loading">
                        <i class="las la-spin la-spinner"></i> &nbsp; Loading . . .
                    </div>
                    <ul id="comments-list" class="comments-list"></ul>
                    <div class="loadMoreBtn_container text-center mt-4" style="display:none;">
                        <button type="button" class="btn btn-primary loadMoreBtn btn-sm">Load More Messages</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(is_user_loggin()): ?>
<script id="quillJSScript" async defer src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
let editor,quill;
const quillJSScript = document.getElementById("quillJSScript");
quillJSScript.onload = function(){
    let script = document.createElement('script');
    script.src = '<?php echo get_site_url(); ?>/plugins/comment/assets/js/image-resize.min.js';    
    script.onload = function(){
        quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar',
                imageResize: {
                    modules: ['Resize', 'DisplaySize', 'Toolbar']
                }
            },
            placeholder: 'Write a message...',
            theme: 'snow' // or 'bubble'
        });
        editor = quill;
    }
    document.head.appendChild(script);
}
</script>
<?php endif; ?>