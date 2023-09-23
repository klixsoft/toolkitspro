$(document).ready(function () {
    $.fn.hasAttr = function(name) {  
        return this.attr(name) !== undefined;
    };

    const getToolErrorMessage = () => {
        try {
            return toolOptions.errormessage;
        } catch (error) {
            
        }
        return 'Unable to download the video. Please check link and try again!!!';
    }

    const getToolDownloadingMessage = () => {
        try {
            return toolOptions.loadingtext;
        } catch (error) {
            
        }
        return 'Downloading';
    }

    $(document).on("submit", ".video_downloader_form", function (e) {
        e.preventDefault();

        const form = $(this);
        const btn = form.find("[type=submit]");
        const prevhtml = btn.html();
        const report = form.find(".video_downloader_report");

        let downloadingModalMessage = "Getting Download Links . . .";
        if( btn.hasAttr("data-modal") ){
            downloadingModalMessage = btn.attr("data-modal");
        }

        const recaptcha = validateCaptcha();
        if (!recaptcha.valid) {
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
                // btn.attr("disabled", true).html(`<i class='las la-spinner la-spin me-1'></i> ${getToolDownloadingMessage()} . . .`);
                report.closest(".form-group").addClass("d-none");
                show_loadingModal(downloadingModalMessage);
            },
            error: function (error) {
                hide_loadingModal();
                $(document.body).trigger("has_message", {
                    type: "danger",
                    messages: [
                        getToolErrorMessage()
                    ]
                });
            },
            success: function (response) {
                if (response.success) {
                    report.html(response?.message);
                    report.closest(".form-group").removeClass("d-none");

                    $("html, body").animate({
                        scrollTop: report.offset().top - 150
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
            complete: function () {
                reloadv3_captcha();
                hide_loadingModal();
            }
        });
    });
});