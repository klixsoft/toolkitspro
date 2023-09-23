$(document).ready(function(){
    
    function generate_description(){
        let desc = '';
        $(document).find(".inputchange").each(function(){
            desc += $(this).val() + "\n\n";
        });

        $(document).find("#yt_description_result").val(desc).trigger("change");
    }

    $(document).on("change keyup paste", ".inputchange", function(){
        generate_description();
    });

    generate_description();


    $(document).on("click", ".yt-desc-generator_copy", function () {
        const val = $(document).find("#yt_description_result").val();
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
                    "Youtube Description is empty!!!"
                ]
            });
        }
    });

    $(document).on("click", ".yt-desc-generator_download", function () {
        const val = $(document).find("#yt_description_result").val();
        if (val && val.length > 0) {
            download_text(val, "description.txt", "data:text/plain;charset=utf-8");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active");
            }, 1000);
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: [
                    "Youtube Description is empty!!!"
                ]
            });
        }
    });
});