"use strict";
var TAAG = TAAG || {};
TAAG.fonts = {};
TAAG.fonts.figlet = [];
TAAG.fonts.figlet[0] = new Figlet();
TAAG.fonts.aol = [];
TAAG.fonts.aol[0] = new AolFont();
TAAG.currentFont = null;
TAAG.testingAll = false;
TAAG.lastAjax = {};
TAAG.opts = {};
TAAG.opts.progComment = "";
TAAG.opts.whiteSpace = "";
var AOLFONTS = {};
var AOLFONTS = {};
TAAG.fontReady = function() {
    if (TAAG.currentFont !== null) {
        return true
    }
    return false
};
TAAG.displayClass = function(className, fontName) {
    if (className !== 'fig') {
        return className
    }
    var ansiFonts = {};
    ansiFonts['3D-ASCII'] = true;
    ansiFonts['Bloody'] = true;
    ansiFonts['Calvin S'] = true;
    ansiFonts['Delta Corps Priest 1'] = true;
    ansiFonts['Electronic'] = true;
    ansiFonts['Elite'] = true;
    ansiFonts['KOLO-TDF'] = true;
    ansiFonts['ANSI Shadow'] = true;
    ansiFonts['Stronger Than All'] = true;
    ansiFonts['THIS'] = true;
    ansiFonts['The Edge'] = true;
    return ansiFonts[fontName] ? 'fig-ansi' : 'fig'
}
TAAG.getText = function(txt, txtId, font, fontName) {
    font = font || TAAG.currentFont;
    var txt = font.getText(txt);
    txt = txt.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    if (TAAG.opts.whiteSpace) {
        if (TAAG.opts.whiteSpace !== " " && font.getFontType() === "fig") {
            txt = txt.replace(/ /g, TAAG.opts.whiteSpace)
        }
    }
    var progCommentOpt = TAAG.opts.progComment;
    if (progCommentOpt) {
        if (progCommentOpt === "c") {
            txt = "/***\n *    " + txt.split("\n").join("\n *    ") + "\n */"
        } else if (progCommentOpt === "lua") {
            txt = "--[[\n" + txt.split("\n").join("\n") + "\n--]]"
        } else if (progCommentOpt === "c++") {
            txt = "//  " + txt.split("\n").join("\n//  ")
        } else if (progCommentOpt === "echo") {
            txt = "echo \"" + txt.replace(/"/g, '\\"').replace(/`/g, '\\`').split("\n").join("\";\necho \"") + '";'
        } else if (progCommentOpt === "bash") {
            txt = "#  " + txt.split("\n").join("\n#  ")
        } else if (progCommentOpt === "fortran") {
            txt = "!  " + txt.split("\n").join("\n!  ")
        } else if (progCommentOpt === "vb") {
            txt = "'  " + txt.split("\n").join("\n'  ")
        } else if (progCommentOpt === "mysql") {
            txt = "--  " + txt.split("\n").join("\n--  ")
        }
    }
    fontName = fontName || fontList.options[fontList.selectedIndex].value.split('.')[0];
    var idStr = (typeof txtId !== "undefined") ? "id='" + txtId + "'" : "id='taag_output_text'";
    return "<pre " + idStr + " style='float:left;' class='" + TAAG.displayClass(font.getFontType(), fontName) + "' contenteditable='false'>" + txt + "</pre><div style=\"clear:both\"></div>"
};
TAAG.useFont = function(fontName) {
    var ii, fontList = document.getElementById("fontList"),
        len = fontList.length,
        listedName, index = -1;
    for (ii = 0; ii < len; ii++) {
        listedName = fontList.options[ii].text;
        if (listedName === fontName) {
            index = ii;
            break
        }
    }
    if (index === -1) {
        return
    }
    fontList.selectedIndex = index;
    TAAG.updateFont(fontList.options[fontList.selectedIndex].value, function() {
        TAAG.updateDisplay()
    })
};
TAAG.updateFont = function(newFont, callback, secondAttempt) {
    var fontUrl = allsmarttools.siteurl + "tools/ascii-art-generator/assets/fonts/" + newFont;
    var isFiglet = (fontUrl.substr(fontUrl.length - 3, 3) !== "aol") ? true : false;
    if (isFiglet) {
        TAAG.lastAjax = $.ajax({
            url: fontUrl,
            success: function(res) {
                TAAG.fonts.figlet[0].load(res);
                TAAG.currentFont = TAAG.fonts.figlet[0];
                var charWidth = document.getElementById("taagCharWidth");
                TAAG.currentFont.loadHorizontalOpts(charWidth.options[charWidth.selectedIndex].value);
                var charHeight = document.getElementById("taagCharHeight");
                TAAG.currentFont.loadVerticalOpts(charHeight.options[charHeight.selectedIndex].value);
                TAAG.setHash();
                if (callback) {
                    callback()
                }
            }
        })
    } else {
        if (typeof AOLFONTS[newFont] !== "undefined") {
            TAAG.fonts.aol[0].load(AOLFONTS[newFont]);
            TAAG.currentFont = TAAG.fonts.aol[0];
            TAAG.updateDisplay();
            TAAG.setHash();
            if (callback) {
                callback()
            }
        } else {
            if (!AOLFONTS.isLoaded && secondAttempt !== true) {
                var aolScript = document.createElement("script");
                aolScript.src = allsmarttools.siteurl + "tools/ascii-art-generator/assets/js/macros.min.js";
                aolScript.charset = "ISO-8859-1";
                aolScript.onload = function() {
                    TAAG.updateFont(newFont, callback, true)
                };
                aolScript.onreadystatechange = function() {
                    if (this.readyState === 'complete' || this.readyState === 'loaded') {
                        TAAG.updateFont(newFont, callback, true)
                    }
                };
                var head = document.getElementsByTagName('head')[0];
                head.appendChild(aolScript)
            } else {
                console.log("Error: Something went wrong")
            }
        }
    }
};
TAAG.updateDisplay = function() {
    var inputTxt = document.getElementById("inputText");
    var output = document.getElementById("outputFigDisplay");
    var fontList = document.getElementById("fontList");
    document.getElementById("outputFigDisplay").className = TAAG.displayClass(TAAG.currentFont.getFontType(), fontList.options[fontList.selectedIndex].value.split('.')[0]);
    output.innerHTML = TAAG.getText(inputTxt.value);
    TAAG.changePage()
};
TAAG.changePage = function(newPage) {
    TAAG.currentPage = newPage;
    if (TAAG.lastAjax) {
        if (typeof TAAG.lastAjax.abort !== "undefined") {
            TAAG.lastAjax.abort()
        }
    }
};
TAAG.setHash = function(page) {
    var txtBox = document.getElementById("inputText");
    var fontList = document.getElementById("fontList");
    var params = [],
        paramsStr;
    var hBox = document.getElementById("taagCharWidth");
    var hBoxValue = hBox.options[hBox.selectedIndex].value;
    var vBox = document.getElementById("taagCharHeight");
    var vBoxValue = vBox.options[vBox.selectedIndex].value;
    if (hBoxValue !== "default") {
        params.push("h=" + hBox.selectedIndex)
    }
    if (vBoxValue !== "default") {
        params.push("v=" + vBox.selectedIndex)
    }
    if (TAAG.opts.progComment !== "") {
        params.push("c=" + encodeURIComponent(TAAG.opts.progComment))
    }
    if (TAAG.opts.whiteSpace !== "") {
        params.push("w=" + encodeURIComponent(TAAG.opts.whiteSpace))
    }
    params.push("f=" + encodeURIComponent(fontList.options[fontList.selectedIndex].text));
    params.push("t=" + encodeURIComponent(txtBox.value));
    paramsStr = params.join("&");
    window.location.hash = "#" + paramsStr
};
TAAG.loadHash = function(hash) {
    if (hash.length <= 1) {
        hash = "#nope=nope"
    }
    var elms = hash.substr(1).split("&");
    var ii, params = {},
        param, len;
    var fontList = document.getElementById("fontList");
    len = elms.length;
    for (ii = 0; ii < len; ii++) {
        param = elms[ii].split("=");
        if (param.length === 2) {
            params[param[0]] = decodeURIComponent(param[1])
        }
    }
    if (params["h"]) {
        var num = parseInt(params["h"], 10);
        var hBox = document.getElementById("taagCharWidth");
        if (num >= 0 && num < hBox.options.length) {
            hBox.selectedIndex = num
        }
    }
    if (params["v"]) {
        var num = parseInt(params["v"], 10);
        var vBox = document.getElementById("taagCharHeight");
        if (num >= 0 && num < vBox.options.length) {
            vBox.selectedIndex = num
        }
    }
    if (params["c"]) {
        TAAG.opts.progComment = params["c"]
    }
    if (params["w"]) {
        TAAG.opts.whiteSpace = params["w"].substr(0, 1)
    }
    if (params["f"]) {
        len = fontList.options.length;
        for (ii = 0; ii < len; ii++) {
            if (fontList.options[ii].text === params["f"]) {
                fontList.selectedIndex = ii;
                break
            }
        }
    }
    if (params["t"]) {
        var txtBox = document.getElementById("inputText");
        txtBox.value = params["t"]
    }
    var fontList = document.getElementById("fontList");
    TAAG.updateFont(fontList.options[fontList.selectedIndex].value, function() {
        TAAG.updateDisplay();
        var txtBox = document.getElementById("inputText");
        txtBox.focus();
        var tmp = txtBox.value;
        txtBox.value = "";
        txtBox.value = tmp
    })
};
$(document).ready(function() {
    TAAG.loadHash(window.location.hash);
    $("#inputText").bind("keyup", function(evt) {
        evt = evt || window.event;
        if (TAAG.fontReady()) {
            TAAG.updateDisplay()
        }
    });
    $("#inputText").bind("blur", function(evt) {
        TAAG.setHash()
    });
    $("#fontList").bind("change", function() {
        var fontList = document.getElementById("fontList");
        TAAG.updateFont(fontList.options[fontList.selectedIndex].value, function() {
            TAAG.updateDisplay()
        })
    });
    $("#taagCharWidth, #taagCharHeight").bind("change", function() {
        var fontList = document.getElementById("fontList");
        TAAG.updateFont(fontList.options[fontList.selectedIndex].value, function() {
            TAAG.updateDisplay()
        })
    });
    $(document).on("click", ".ascii-text-art_copy", function() {
        const val = $(document).find("#taag_output_text").text();
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            alertMessage("error", "Convert Text to ASCII Arts first!!!")
        }
    });
    $(document).on("click", ".ascii-text-art_download", function() {
        const val = $(document).find("#taag_output_text").text();
        if (val && val.length > 0) {
            download_text(val, "banner.txt", "data:plain/text;charset=utf-8");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            alertMessage("Convert Text to ASCII Arts first!!!")
        }
    });
    $(document).on("click", ".ascii-text-art_info", function() {
        if (!TAAG.fontReady()) {
            return
        }
        var comment = TAAG.currentFont.getComment().replace("<", "&lt;").replace(">", "&gt;").replace(/\bhttp:[^ \)\n\<,]+/g, "<a href='$&' target='_new'>$&</a>");
        const infoModal = $(document).find("#infoModal");
        if (infoModal.length > 0) {
            infoModal.find(".modal-title").text("Font Information");
            infoModal.find(".modal-body").html(`<pre style="outline:none;background:transparent;border:none;font-family: var(--fontfamily);font-size: 1rem;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;">${comment}</pre>`);
            infoModal.modal("show")
        }
    })
});