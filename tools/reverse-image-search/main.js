$(document).ready(function() {
    const validFile = (file) => {
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        return validImageTypes.includes(file.type)
    }
    $(document).on("change", ".imageFileUpload", function() {
        const $this = $(this);
        const file = $this[0].files;
        if (validFile(file)) {
            alertMessage("error", "Please upload only images!!!");
            $this.val("");
            return false
        }
        const report = $(document).find(".reverse_image_search_result .row");
        let data = new FormData();
        data.append("file", file[0]);
        data.append("action", "reverse_image_search");
        data.append("tool", "reverse-image-search");
        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = ((evt.loaded / evt.total) * 100);
                        $(document).find("#loadingModal .message").text(`Searching Images ${percentComplete}%...`)
                    }
                }, false);
                return xhr
            },
            type: 'POST',
            url: allsmarttools.ajaxurl,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                show_loadingModal("Searching Images 0% . . . ");
                report.closest(".form-group").removeClass("d-none")
            },
            error: function() {
                alertMessage("error", "Unable to upload Image File. Please try again!!!")
            },
            success: function(response) {
                if (response.success) {
                    report.html(response.message)
                } else {
                    alertMessage("error", response.message)
                }
            },
            complete: function() {
                hide_loadingModal();
                $this.val("")
            }
        })
    })
});