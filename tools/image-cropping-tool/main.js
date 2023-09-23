$(document).ready(function() {
    const imageFileUpload = $(document).find(".imageFileUpload");
    var uploadedImageType = 'image/jpeg';
    var options = {
        aspectRatio: NaN,
        viewMode: 3,
        ready: function(e) {
            if (e.type == 'ready') {
                $(document).find(".aspect_ratio_calculator .aspect_item").removeClass("active");
                $(document).find(".aspect_ratio_calculator .preview[data-ratio=free]").parent().addClass("active")
            }
        },
        crop: function(e) {
            const height = Math.round(e.detail.height);
            const width = Math.round(e.detail.width);
            const posX = Math.round(e.detail.x);
            const posY = Math.round(e.detail.y);
            $(document).find("input[name=posX]").val(posX);
            $(document).find("input[name=posY]").val(posY);
            $(document).find("input[name=width]").val(width);
            $(document).find("input[name=height]").val(height)
        }
    };
    const image = document.getElementById("imageeditor");
    let cropper;
    $(document).on("click", ".aspect_ratio_calculator .aspect_item", function() {
        $(document).find(".aspect_ratio_calculator .aspect_item").removeClass("active");
        $(this).addClass("active");
        let ratio = $(this).find(".preview").attr("data-ratio");
        if (ratio) {
            if (ratio == "free") {
                cropper.setAspectRatio(NaN)
            } else {
                ratio = ratio.split(":");
                cropper.setAspectRatio(parseFloat(ratio[0]) / parseFloat(ratio[1]))
            }
        }
    });
    $(document).on("keydown change paste", "input[name=width], input[name=height], input[name=posX], input[name=posY]", function() {
        const width = parseFloat($(document).find("input[name=width]").val());
        const height = parseFloat($(document).find("input[name=height]").val());
        const posX = parseFloat($(document).find("input[name=posX]").val());
        const posY = parseFloat($(document).find("input[name=posY]").val());
        if (!isNaN(width) && !isNaN(height) && !isNaN(posX) && !isNaN(posY)) {
            let cropperNewOptions = cropper.getData();
            cropperNewOptions["width"] = width;
            cropperNewOptions["height"] = height;
            cropperNewOptions["x"] = posX;
            cropperNewOptions["y"] = posY;
            cropper.setData(cropperNewOptions)
        }
    });
    $(document).on("click", ".docs-buttons .btn", function() {
        const method = $(this).attr("data-method");
        const option = $(this).attr("data-option");
        const secondoption = $(this).attr("data-second-option");
        if (method == 'zoom') {
            cropper.zoom(option)
        } else if (method == 'move') {
            cropper.move(option, secondoption)
        } else if (method == 'rotate') {
            cropper.rotate(option)
        } else if (method == 'scaleX') {
            cropper.scaleX(option);
            $(this).attr("data-option", -option)
        } else if (method == 'scaleY') {
            cropper.scaleY(option);
            $(this).attr("data-option", -option)
        }
    });

    function createEditor(files, callback) {
        var file;
        if (files && files.length) {
            file = files[0];
            if (/^image\/\w+/.test(file.type)) {
                uploadedImageType = file.type;
                uploadedImageName = file.name;
                image.src = uploadedImageURL = URL.createObjectURL(file);
                if (cropper) {
                    cropper.destroy()
                }
                cropper = new Cropper(image, options);
                $(document).find(".image_upload_area").hide();
                $(document).find(".image_edit_area").show()
            } else {
                alertMessage('error', 'Please choose an image file.')
            }
            if (typeof callback == 'function') {
                callback()
            }
        }
    }
    $(document).on("change", ".imageFileUpload", function() {
        const files = $(this)[0].files;
        createEditor(files, () => {
            $(this).val("")
        })
    });
    let downloadResult;
    $(document).on("click", "#cropImageBtn", function() {
        const modal = $(document).find("#imagePreview");
        downloadResult = cropper.getCroppedCanvas({
            "maxWidth": 4096,
            "maxHeight": 4096
        });
        modal.find(".modal-body").html(downloadResult);
        modal.modal("show")
    });
    $(document).on("click", ".finalDownloadImage", function() {
        const downloadlink = downloadResult.toDataURL(uploadedImageType);
        const aTag = document.createElement("a");
        aTag.setAttribute("download", "download");
        aTag.setAttribute("href", downloadlink);
        aTag.click()
    });
    window.afterDragFiles = function(files) {
        if (files.length > 0) {
            createEditor(files, () => {})
        }
    }
});