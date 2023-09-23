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
        const report = form.find(".video_downloader_report");

        let downloadingModalMessage = "Getting Download Links . . .";
        if( btn.hasAttr("data-modal") ){
            downloadingModalMessage = btn.attr("data-modal");
        }

        const recaptcha = validateCaptcha();
        if (!recaptcha.valid) {
            alertMessage("error", allsmarttools?.captcha?.error_message || "Captcha is Required!!!");
            return;
        }

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend: function () {
                report.html("");
                report.closest(".form-group").addClass("d-none");
                show_loadingModal(downloadingModalMessage);
            },
            error: function (error) {
                hide_loadingModal();
                alertMessage("error", getToolErrorMessage());
            },
            success: function (response) {
                if (response.success) {
                    report.html(response?.message);
                    report.closest(".form-group").removeClass("d-none");

                    $("html, body").animate({
                        scrollTop: report.offset().top - 150
                    })
                } else {
                    alertMessage("error", response.message);
                }
            },
            complete: function () {
                hide_loadingModal();
            }
        });
    });
});