$(document).ready(function() {
    let originalCode = "";
    const modal = $(document).find("#howToUseModal");
    $(document).on("change", "#base64Image", function() {
        const files = $(this)[0].files;
        if (files && files.length > 0) {
            const file = files[0];
            modal.find(".imageTag").val("").trigger("change");
            modal.find(".cssTag").val("").trigger("change");
            if (/^image\/\w+/.test(file.type)) {
                const fileReader = new FileReader();
                fileReader.onload = function(fileLoadedEvent) {
                    originalCode = fileLoadedEvent.target.result;
                    const srcDataParts = originalCode.split("base64,");
                    $(document).find("#image-to-base64_result").val(srcDataParts[1]).trigger("change");
                    modal.find(".imageTag").val(`<img src="${originalCode}"alt="Image">`).trigger("change");
                    modal.find(".cssTag").val(`background-image:url(${originalCode});`).trigger("change")
                }
                fileReader.readAsDataURL(file)
            } else {
                alertMessage("error", "Only Image files are allowed!!!")
            }
        }
    });
    $(document).on("click", ".image-to-base64_copy", function() {
        const val = $(document).find("#image-to-base64_result").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["Base64 is empty. Please convert your Image first!!!"]
            })
        }
    });
    $(document).on("click", ".image-to-base64_download", function() {
        $(document).find("#howToUseModal").modal("show")
    })
});