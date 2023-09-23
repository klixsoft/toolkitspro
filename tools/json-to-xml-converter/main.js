$(document).ready(function() {
    const validateEditor = async function() {
        let state = false;
        await editorInstance.validate().then(res => {
            if (res.length != 0) {
                res.forEach(r => {
                    $(document.body).trigger("has_message", {
                        type: "danger",
                        messages: [r.message]
                    })
                })
            } else {
                state = true
            }
        });
        return state
    }
    const formatXml = function(xml, tab = 4) {
        var formatted = '';
        var reg = /(>)(<)(\/*)/g;
        xml = xml.replace(reg, '$1\r\n$2$3');
        var pad = 0;
        jQuery.each(xml.split('\r\n'), function(index, node) {
            var indent = 0;
            if (node.match(/.+<\/\w[^>]*>$/)) {
                indent = 0
            } else if (node.match(/^<\/\w/)) {
                if (pad != 0) {
                    pad -= 1
                }
            } else if (node.match(/^<\w[^>]*[^\/]>.*$/)) {
                indent = 1
            } else {
                indent = 0
            }
            var padding = '';
            for (var i = 0; i < pad; i++) {
                padding += '  '
            }
            formatted += padding + node + '\r\n';
            pad += indent
        });
        return formatted
    };
    const convertToXml = async function() {
        const state = await validateEditor();
        if (state) {
            var InputJSON = editorInstance.get();
            var x2js = new X2JS();
            var output = x2js.json2xml_str(InputJSON);
            output = formatXml(output);
            var formated_xml = '<?xml version="1.0" encoding="UTF-8" ?>\n<root>\n' + output + '</root>';
            $(document).find("#json_to_xml_converter_result").val(formated_xml)
        } else {}
    };
    const editorInstance = new JSONEditor(document.getElementById("jsoneditor"), {
        mode: "code",
        onError: function(err) {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: [err.toString()]
            })
        },
        indentation: 4
    });
    $(document).on("change", "#fileInput", function(e) {
        var file = $(this)[0].files[0];
        if (file.type != "application/json") {
            $(this).val("");
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["Only .json file supported!!!"]
            });
            return
        }
        var reader = new FileReader();
        reader.readAsText(file, "UTF-8");
        reader.onload = function(evt) {
            editorInstance.setText(evt.target.result)
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
        getURLContent(url, "json", function(response) {
            editor.getSession().setValue(response);
            loadingele.removeClass("gettingContent");
            inputEle.val("")
        }, function(error, req) {
            loadingele.removeClass("gettingContent");
            inputEle.val("")
        })
    });
    $(document).on("click", ".convertToXML", function() {
        convertToXml()
    });
    $(document).on("click", ".json_to_xml_converter_copy", function() {
        const val = $(document).find("#json_to_xml_converter_result").val();
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
                messages: ["XML is empty. Please convert your JSON code first!!!"]
            })
        }
    });
    $(document).on("click", ".json_to_xml_converter_download", function() {
        const val = $(document).find("#json_to_xml_converter_result").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            download_text(val, "sample.json", "data:application/json;charset=utf-8");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            $(document.body).trigger("has_message", {
                type: "danger",
                messages: ["XML is empty. Please convert your JSON code first!!!"]
            })
        }
    })
});