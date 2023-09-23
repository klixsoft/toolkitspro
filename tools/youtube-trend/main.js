$(document).ready(function(){

    $(document).on("submit", ".youtube-trend_submit_form", function(e){
        e.preventDefault();

        const form = $(this);
        const btn = form.find("[type=submit]");
        const prevhtml = btn.html();
        const report = form.find(".youtube-trend_report");

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
                show_loadingModal("Searching Trends . . .");
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
                hide_loadingModal();
                btn.attr("disabled", false);
            }
        });
    });

});