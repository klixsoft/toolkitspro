$(document).ready(function(){

    $(document).on("click", ".yt_tags", function(){
        const tag = $(this).text().trim();
        let inputEle = $(document).find('#tags_result');
        let textValue = inputEle.val();

        if( textValue.length > 0 ){
            textValue = textValue + ", " + tag;
        }else{
            textValue = tag;
        }
        textValue = textValue.trim();
        inputEle.val(textValue).trigger("change");
    });

    $(document).on("submit", ".youtube-tag-generator_submit_form", function(e){
        e.preventDefault();

        const form = $(this);
        const btn = form.find("[type=submit]");
        const report = form.find(".youtube-tag-generator_report");

        const recaptcha = validateCaptcha();
        if( ! recaptcha.valid ){
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: [
                    allsmarttools?.captcha?.error_message || "Captcha is Required!!!"
                ]
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend: function () {
                show_loadingModal("Generating . . .");
                btn.attr("disabled", true);
                report.closest(".form-group").addClass("d-none");
                report.html("");
            },
            error: function (error) {
                $(document.body).trigger("has_message", {
                    type: "danger",
                    messages: [
                        "Unable to Search Youtube Trend. Please try again!!!"
                    ]
                });
            },
            success: function (response) {
                if (response.success) {
                    report.html(response?.message);
                    report.closest(".form-group").removeClass("d-none");

                    $("html, body").animate({
                        scrollTop : report.offset().top - 150
                    })
                } else {
                    $(document.body).trigger("has_message", {
                        type: "danger",
                        messages: [
                            response.message
                        ]
                    });
                }
            },
            complete : function(){
                btn.attr("disabled", false);
                hide_loadingModal();
            }
        });
    });


    $(document).on("click", ".yt-tags-formatter_copy", function () {
        const val = $(document).find("#tags_result").val();
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active");
            }, 1000);
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: [
                    "Favourite tags is empty. Please add some tags to Favourite list!!!"
                ]
            });
        }
    });

    $(document).on("click", ".yt-tags-formatter_download", function () {
        const val = $(document).find("#tags_result").val();
        if (val && val.length > 0) {
            download_text(val, "tags.txt", "data:text/plain;charset=utf-8");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active");
            }, 1000);
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: [
                    "Favourite tags is empty. Please add some tags to Favourite list!!!"
                ]
            });
        }
    });

    $(document).on("click", ".yt-tags-clear_result", function(e){
        $(document).find("#tags_result").val("").trigger("change");
    });

});