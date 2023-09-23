$(document).ready(function(){
    let cmtLoading = $(document).find('.comment_loading');
    let page = 1;
    let total = 0;
    let postInitialID = parseInt($(document).find("#comment_id").val());
    if (cmtLoading) {
        cmtLoading.show();
    }


    function hasMoreComments() {
        if (total > page) {
            $(document).find('.loadMoreBtn_container').fadeIn();
        } else {
            $(document).find('.loadMoreBtn_container').fadeOut();
        }
    }

    function get_postin_id() {
        try {
            if (window.location.hash) {
                let hash = window.location.hash.substring(1);
                if (hash.length > 0) {
                    hash = hash.toLowerCase();
                    if (hash.includes("comment")) {
                        const commentid = hash.replace(/[^\d.]/g, '');
                        return parseInt(commentid);
                    }
                }
            }
        } catch (e) {

        }
        return 0;
    }

    function setup_reviews(reviews){
        if( $(document).find(".totalrating_count").length == 0 ){
            return false;
        }
        
        $(document).find(".totalrating_count").text(`${reviews?.total || 0} ratings`);
        $(document).find("#rating_overview").text(reviews?.overview || 0);
        $(document).find(".rating-stars .filled-star").css("width", `${reviews?.per || 0}%`);

        Object.keys(reviews?.single || []).map((item) => {
            const progressEle = $(document).find(`.rating-divided .${item}`);
            if( progressEle.length > 0 ){
                const totalSingleRate = reviews?.single[item] || 0;
                progressEle.find(".rating-value").text(totalSingleRate);

                let per = 0;
                if( reviews?.total ){
                    per = Math.round((totalSingleRate / reviews.total) * 1000) / 10;
                }
                progressEle.find(".progress-bar").css("width", `${per}%`);
                progressEle.find(".progress-bar").attr("aria-valuenow", per);
            }
        });
    }

    function get_hamrocsit_comments() {
        let id = $(document).find("#comment_id").val();
        let order = $(document).find('.hamrocsit_filter_value').val();
        if (typeof order == "undefined" || order == null) {
            order = 1;
        }

        const postin = get_postin_id();

        order = parseInt(order);
        let loaderBtn = null;
        if (order == 0) {
            loaderBtn = $(document).find(".hamrocsit-reacted");
        } else {
            loaderBtn = $(document).find(".hamrocsit-hottest");
        }
        let prevHTML = loaderBtn.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: 'get_comment',
                postID: id,
                order: order,
                page: page,
                postin: postin
            },
            dataType: "json",
            beforeSend: function () {
                loaderBtn.attr('disabled', true).html('<i class="las la-spin la-spinner"></i>');
            },
            error: function (error) {
                total = 0;
                $(document).find('.loadMoreBtn').attr('disabled', false).html("Load More Messages");
                hasMoreComments();
            },
            success: function (response) {
                $(document).find(".hamrocs_comment_count").html(response.comments).attr("title", response.comments_text);
                if (page == 1) {
                    $(document).find("#comments-list").html(response.html);
                    total = parseInt(response.parent_count);
                } else {
                    $(document).find("#comments-list").append(response.html);
                }

                $(document).find('.loadMoreBtn').attr('disabled', false).html("Load More Messages");
                hasMoreComments();

                if ($(document).find('.hamrocsit-editor-buttons-right').hasClass('reply')) {
                    $(document).find('.replyCloseContainer').trigger("click");
                }

                setup_reviews(response.reviews);

                if( postin && page == 1 ){
                    const shareCommentEle = $(document).find(`#comment-${postin}`);
                    if( shareCommentEle.length > 0 ){
                        $('html, body').animate({
                            scrollTop: shareCommentEle.offset().top - 100
                        }, 800, function(){
                            shareCommentEle.fadeOut(400).fadeIn(400);
                        });
                    }
                }

                if( response?.comments <= 0 ){
                    $(document).find("#comments-list").addClass("nocomments");
                }else{
                    $(document).find("#comments-list").removeClass("nocomments");
                }

                try {
                    if( $(document).find("[title]").length ){
                        $(document).find("[title]").toolTip();
                    }
                } catch (error) {
                    
                }

                if (page == 1) {
                    const hash = window.location.hash;
                    if( hash && hash.match(/^#comment_\d+$/) ){
                        const target = $(document).find(hash);
                        if (target.length) {
                            $('html, body').animate({
                                scrollTop: target.offset().top - 200
                            }, 1000);
                        }
                    }
                }
            },
            complete: function () {
                if (cmtLoading) {
                    cmtLoading.hide();
                }
                loaderBtn.attr('disabled', true).html(prevHTML);
            }
        });
    }

    if ($(document).find(".hamrocs_comment_count").length > 0)
        get_hamrocsit_comments(postInitialID);

    if (typeof quill != "undefined" && quill != null) {

        $(document).on('click', '.hamrocsit-reacted', function () {
            $(document).find('.hamrocsit-filter').removeClass('active');
            $(document).find('.hamrocsit_filter_value').val('0');
            $(this).addClass('active');
            page = 1;
            get_hamrocsit_comments(postInitialID);
        });

        $(document).on('click', '.hamrocsit-hottest', function () {
            $(document).find('.hamrocsit-filter').removeClass('active');
            $(document).find('.hamrocsit_filter_value').val('1');
            $(this).addClass('active');
            page = 1;
            get_hamrocsit_comments(postInitialID);
        });

        $(document).on('click', '.loadMoreBtn', function () {
            $(this).attr('disabled', true).html('<i class="las la-spin la-spinner"></i> Loading Messages . . .');
            page++;
            get_hamrocsit_comments(postInitialID);
        });


        $(document).on('click', '.replyBtn', function () {
            let parentID = $(this).closest(".comment-head").find('input').val();
            $(document).find("#parent_comment_id").val(parentID).trigger("change");
            $(document).find(".submitButton").html("Reply Message");
            $(document).find(".hamrocsit-editor-buttons-right").addClass("reply");
            $('html, body').animate({
                scrollTop: $(".discssion_title").offset().top - 100
            }, 500);
        });

        $(document).on('click', '.replyCloseContainer', function () {
            $(document).find("#parent_comment_id").val(0);
            $(document).find(".submitButton").html("Submit Message");
            $(document).find(".hamrocsit-editor-buttons-right").removeClass("reply");
        });

        //hs comment form
        $(document).on('click', '.submitButton', function () {
            const postID = $(document).find("#comment_id").val();
            const parent = $(document).find("#parent_comment_id").val();
            const message = quill.root.innerHTML;
            if (quill.getText().trim().length <= 0) {
                alertMessage("error", "Please write a message.");
                return false;
            }

            let ratingVal = 0;
            if( $(document).find(".commentRating").length > 0 ){
                ratingVal = $(document).find(".commentRating [name=rating]:checked").val();
                if( isNaN(ratingVal) ){
                    alertMessage("error", "Please give rating.");
                    return false;
                }
            }

            const btn = $(this);
            btn.attr('disabled', true).html('<i class="las la-spin la-spinner"></i> Submitting . . .');

            $.post(allsmarttools.ajaxurl, {
                action: 'submit_comment',
                postID: postID,
                message: message,
                parent: parent,
                rating : ratingVal
            }, function (data) {
                try {
                    if (data.success) {
                        alertMessage("success", data.message);
                        get_hamrocsit_comments(postInitialID);
                    } else {
                        alertMessage("error", data.message);
                    }
                    quill.root.innerHTML = "";
                    $(document).find('input[name=rating]').prop('checked',false);
                    btn.attr('disabled', false).html("Submit Message");
                } catch (e) {
                    alertMessage("success", "Unable to submit message!!!");
                    quill.root.innerHTML = "";
                    btn.attr('disabled', false).html("Submit Message");
                }
            }, "json");

        })
    }
});