;(function($) {
    "use strict";  

    window.alertMessage = (type, message, title = "Alert", timeout = 4000) => {
        init({
            fade_in: 500,
            fade_out: 500,
            position: 'top-right'
        });
    
        toast({
            title: title,
            description: message,
            type: type,
            timeout: timeout,
            title: title
        });
    };

    const fieldset = $(document).find("fieldset");
    
    function getEachStep(){
        const form = $(document).find("#msform");
        $.ajax({
            type: "POST",
            url: tookitspro.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend: function () {
                form.addClass("loading");
            },
            error: function (error) {
                alertMessage("error", "Unable to proceed next step. Please try again!!!");
            },
            success: function (response) {
                if( response.success ){
                    fieldset.html(response.message);
                    $(document).find("#progressbar ." + response.current).addClass("active");
                }else{
                    alertMessage("error", response.message);
                }
            },
            complete : function(){
                form.removeClass("loading");
            }
        });
    }
    
    if( fieldset.length > 0 ){
        getEachStep();
    }

    $(document).on("click", ".proceedBtn", function(){
        const nextpage = $(this).attr("data-next");
        if( nextpage && nextpage != "undefined" ){
            $(document).find(".currentPage").val(nextpage).trigger("change");
            $(document).find(".pageType").val("next").trigger("change");
            getEachStep();
        }
    });

    $(document).on("click", ".previous_button", function(){
        const nextpage = $(this).attr("data-prev");
        if( nextpage && nextpage != "undefined" ){
            $(document).find(".pageType").val("back").trigger("change");
            $(document).find(".currentPage").val(nextpage).trigger("change");
            getEachStep();
        }
    });
})(jQuery);