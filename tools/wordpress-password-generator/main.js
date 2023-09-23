$(document).ready(function(){
    $(document).on("submit", ".wordpress-password-generator_submit_form", function(e){
        e.preventDefault();

        const form = $(this);
        const btn = $(document).find("#wordpress-password-generator_btn");
        const prevhtml = btn.html();
        const report = form.find(".wordpress-password-generator_report");

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
                btn.attr("disabled", true).html("<i class='las la-spinner la-spin'></i> Generating . . .");
                report.closest(".form-group").addClass("d-none");
                report.html("");
                $(document.body).trigger("clear_message");
            },
            error: function (error) {
                $(document.body).trigger("has_message", {
                    type: "danger",
                    messages: [
                        "Unable to Generate Encrypted Password. Please try again!!!"
                    ]
                });
            },
            success: function (response) {
                if (response.success) {
                    report.html(response?.message);
                    report.closest(".form-group").removeClass("d-none");

                    $(document).find(".copy-clipboard").tooltip({
                        animation: true,
                        html: true
                    });
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
                btn.attr("disabled", false).html(prevhtml);
            }
        });
    });


    $(document).on("click", ".copy-clipboard", function(e){
        e.preventDefault();
        const val = $(this).closest(".row").find(".passed_value").text();
        if( val && val.length > 0 ){
            copy_text(val);
            
            const toolTipid = $(this).attr("aria-describedby");
            const toolTipEle = $(document).find('#' + toolTipid);
            if( toolTipEle.length > 0 ){
                const toolTipContentEle = toolTipEle.find(".tooltip-inner");
                if( toolTipContentEle.length > 0 ){
                    toolTipContentEle.html("Copied");
                    setTimeout(() => {
                        toolTipContentEle.html("Click to Copy");
                    }, 2000);
                }
            }
        }
    });
});

