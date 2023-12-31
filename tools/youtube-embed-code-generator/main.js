$(document).ready(function(){

    function validateYouTubeUrl( url ){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : "";
    }

    function getTime( min, sec ){
        let time = 0;
        if( min.length > 0 ){
            time += parseInt(min) * 60;
        }
        
        if( sec.length > 0 ){
            time += parseInt(sec);
        }

        return time;
    }
    
    function generate_embed_link(){
        const url = $(document).find('input[type=url]').val();
        const ytID = validateYouTubeUrl( url );
        if( ytID.length == 0 ){
            alertMessage("error", "Enter valid Youtube URL!!!");
            return;
        }

        const width = $(document).find('input[name=width]').val();
        const height = $(document).find('input[name=height]').val();
        const sminute = $(document).find('input[name=sminute]').val();
        const sseconds = $(document).find('input[name=sseconds]').val();
        const eminute = $(document).find('input[name=eminute]').val();
        const eseconds = $(document).find('input[name=eseconds]').val();
        const loop = $(document).find('input[name=loop]').is(":checked");
        const autoplay = $(document).find('input[name=autoplay]').is(":checked");
        const hidefullscr = $(document).find('input[name=hidefullscr]').is(":checked");
        const hideplayerctr = $(document).find('input[name=hideplayerctr]').is(":checked");
        const hideytlogo = $(document).find('input[name=hideytlogo]').is(":checked");
        const privacy = $(document).find('input[name=privacy]').is(":checked");
        const responsive = $(document).find('input[name=responsive]').is(":checked");


        let query = [];
        
        /** START TIME */
        const startTime = getTime(sminute, sseconds);
        if( startTime > 0 )
            query.push(`start=${startTime}`);

        /** END TIME */
        const endTime = getTime(eminute, eseconds);
        if( endTime > 0 )
            query.push(`end=${endTime}`);

        /** LOOP */
        if( loop )
            query.push(`loop=1`);

        /** Autoplay */
        if( autoplay )
            query.push(`autoplay=1`);

        /** Hide Full Screen */
        if( hidefullscr )
            query.push(`fs=0`);

        /** Hide Controls */
        if( hideplayerctr )
            query.push(`controls=0`);

        /** Hide Logo */
        if( hideytlogo )
            query.push(`modestbranding=1`);

        /**JOIN QUERY WITH & */
        let queryall = '';
        if( query.length > 0 ){
            queryall = "?" + query.join("&");
        }

        let fullurl = "https://www.youtube";
        if( privacy ){
            fullurl += "-nocookie";
        }
        fullurl += ".com/embed/" + ytID + queryall;


        let html = '';
        if( responsive ){
            html = `<div style="position:relative;height:0;overflow:hidden;padding-bottom:56.25%;border-style:none"><iframe style="position:absolute;top:0;left:0;width:100%;height:100%" src="${fullurl}"></iframe></div>`;
        }else{
            html = `<iframe width="${width}" height="${height}" src="${fullurl}"></iframe>`;
        }

        $(document).find("#yt_embed_preview").html(html);
        $(document).find("#yt_embed_link").val(html).trigger("change");
    }

    $(document).on("click", "#generate_embeded_code", function(){
        generate_embed_link();
    });


    $(document).on("click", ".yt_embed_link_copy", function () {
        const val = $(document).find("#yt_embed_link").val();
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
});