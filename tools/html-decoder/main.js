$(document).ready(function() {
    let editor = ace.edit("jsoneditor");
    editor.getSession().setUseWorker(false);
    editor.setTheme("ace/theme/kuroir");
    editor.getSession().setMode("ace/mode/html");
    editor.getSession().setUseWrapMode(true);
    editor.setOption("indentedSoftWrap", false);
    editor.setOptions({
        fontSize: "15px"
    });
    editor.setShowPrintMargin(false);
    $(document).on("change", "#fileInput", function(e) {
        var file = $(this)[0].files[0];
        if (file.type != "text/html") {
            $(this).val("");
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["Only .html file supported!!!"]
            });
            return
        }
        var reader = new FileReader();
        reader.readAsText(file, "UTF-8");
        reader.onload = function(evt) {
            editor.getSession().setValue(evt.target.result)
        };
        reader.onerror = function(evt) {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["Unable to Read File!!!"]
            })
        }
    });
    $(document).on("change paste", "#urlUpload", function(e) {
        const inputEle = $(this);
        const url = inputEle.val();
        const loadingele = inputEle.parent();
        loadingele.addClass("gettingContent");
        getURLContent(url, "html", function(response) {
            editor.getSession().setValue(response);
            loadingele.removeClass("gettingContent");
            inputEle.val("")
        }, function(error, req) {
            loadingele.removeClass("gettingContent");
            inputEle.val("")
        })
    });
    $(document).on("click", ".decodeHTMLCode", function(e) {
        e.preventDefault();
        const originalValue = editor.getValue();
        const textArea = document.createElement("textarea");
        textArea.innerHTML = originalValue;
        const decodedHTML = textArea.value;
        const outputEle = $(document).find("#html-decoder_result");
        outputEle.val(decodedHTML);
        $("html, body").animate({
            scrollTop: outputEle.closest(".form-group").offset().top - 100
        })
    });
    $(document).on("click", ".html-decoder_copy", function() {
        const val = $(document).find("#html-decoder_result").val();
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["HTML is empty. Please Encode your HTML code first!!!"]
            })
        }
    });
    $(document).on("click", ".html-decoder_download", function() {
        const val = $(document).find("#html-decoder_result").val();
        if (val && val.length > 0) {
            download_text(val, "result.html", "data:text/html;charset=utf-8");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["HTML is empty. Please Encode your HTML code first!!!"]
            })
        }
    })
});