$(document).ready(function() {
    function detectMimeType(b64) {
        var signatures = {
            R0lGODdh: "image/gif",
            R0lGODlh: "image/gif",
            iVBORw0KGgo: "image/png",
            "/9j/": "image/jpg",
            TU0AK: "image/tiff",
            UklGR: "image/webp"
        };
        for (var s in signatures) {
            if (b64.indexOf(s) === 0) {
                return signatures[s]
            }
        }
    }
    $(document).on("change paste", "#base64-to-image_result", function() {
        const base64Code = $(this).val();
        const detectImageType = detectMimeType(base64Code);
        if (detectImageType) {
            $(document).find(".image_output").removeClass("d-none");
            const imageURL = `data:${detectImageType};base64,${base64Code}`;
            $(document).find(".downloadImageLink").attr("href", imageURL);
            $(document).find(".image_output_container").html(`<img src="${imageURL}"alt="Image"/>`)
        }
    });
    $(document).on("click", ".base64-to-image_copy", function() {
        const val = $(document).find("#base64-to-image_result").val();
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
    })
});