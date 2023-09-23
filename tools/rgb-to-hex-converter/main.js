$(document).ready(function() {
    function get_color_value(classname) {
        const value = $(document).find("." + classname).val();
        if (value && value.length > 0) {
            if (parseInt(value) > 255) {
                return 255
            }
            return parseInt(value)
        }
        return 0
    }

    function rgbToHsl(r, g, b) {
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        const l = Math.floor((max + min) / ((0xff * 2) / 100)) 
        
        if (max === min) return [0, 0, l];

        const d = max - min;
        const s = Math.floor((d / (l > 50 ? 0xff * 2 - max - min : max + min)) * 100);
        
        if (max === r) return [Math.floor(((g - b) / d + (g < b && 6)) * 60), s, l];

        return max === g ? [Math.floor(((b - r) / d + 2) * 60), s, l] : [Math.floor(((r - g) / d + 4) * 60), s, l];
    }

    function rgbToHSLText(r, g, b) {
        const hslArray = rgbToHsl(r, g, b);
        return `hsl(${hslArray[0]},${hslArray[1]}%,${hslArray[2]}%)`
    }

    function componentToHex(c) {
        var hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex
    }

    function rgbToHex(r, g, b) {
        return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b)
    }

    function set_color_background() {
        const red = get_color_value("rgb_input_red");
        const green = get_color_value("rgb_input_green");
        const blue = get_color_value("rgb_input_blue");
        $(document).find(".color_pallate").css("background", `rgb(${red},${green},${blue})`);
        $(document).find(".rgbcolorcode").val(`rgb(${red},${green},${blue})`);
        $(document).find(".hexcolorcode").val(rgbToHex(red, green, blue));
        $(document).find(".hslcolorcode").val(rgbToHSLText(red, green, blue))
    }
    $(document).on("change", ".rgb-to-hex-converter_content input.rgb_input", function() {
        const value = $(this).val();
        if (value.length > 0) {
            if (parseInt(value) > 255) {
                $(this).val("255");
                value = "255"
            }
        } else {
            $(this).val("0");
            value = "0"
        }
        $(this).closest(".rgb_db").find(".form-range").val(value);
        set_color_background()
    });
    
    $(document).on("change", ".rgb-to-hex-converter_content input.form-range", function() {
        const value = $(this).val();
        $(this).closest(".rgb_db").find(".rgb_input").val(value);
        set_color_background()
    });
    
    set_color_background();

    $(document).on("click", ".copycolorcode", function(e) {
        e.preventDefault();
        const value = $(this).closest(".input-group").find("input").val();
        if (value && value.length > 0) {
            copy_text(value);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        }
    })
});