$(document).ready(function () {
    const EncodeDecode = {
        encode: (str = '') => {
            if (typeof str != 'string') {
                throw new Error('Please provide string to encode.')
            }

            return encodeURIComponent(str).replace(/!/g, '%21')
                .replace(/'/g, '%27')
                .replace(/\(/g, '%28')
                .replace(/\)/g, '%29')
                .replace(/\*/g, '%2A')
                .replace(/%20/g, '+')
        },
        decode: (str = '') => {
            if (typeof str != 'string') {
                throw new Error('Please provide string to decode')
            }

            return decodeURIComponent((str).replace(/\+/g, '%20'))
        }
    };

    $(document).on("click", ".whois_checker_copy", function () {
        const val = $(document).find("#url_encode_url_text").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active");
            }, 1000);
        } else {
            alertMessage("error", "URL should not be empty!!!");
        }
    });

    $(document).on("click", "#encode_url_btn", function () {
        const val = $(document).find("#url_encode_url_text").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            try {
                const encodeurl = EncodeDecode.encode(val);
                $(document).find("#url-encoder-decoder_result").val(encodeurl);
            } catch (error) {
                alertMessage("error", error.message);
            }
        } else {
            alertMessage("error", "URL should not be empty!!!");
        }
    });

    $(document).on("click", "#decode_url_btn", function () {
        const val = $(document).find("#url_encode_url_text").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            try {
                const encodeurl = EncodeDecode.decode(val);
                $(document).find("#url-encoder-decoder_result").val(encodeurl);
            } catch (error) {
                alertMessage("error", error.message);
            }
        } else {
            alertMessage("error", "URL should not be empty!!!");
        }
    });
});