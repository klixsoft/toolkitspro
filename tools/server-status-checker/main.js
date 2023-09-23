$(document).ready(function(){

    let urlparts = [];

    function start_checking_statuscode( urlIndex ){
        if( urlIndex >= urlparts.length ){
            $(document).find("#server_status_checker_btn").attr("disabled", false);
            return false;
        }

        const statuscodetr = $(document).find(`.status_code_${urlIndex}_checking`);
        $("html, body").animate({
            scrollTop : statuscodetr.offset().top - 100
        }, 100);
        
        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                tool : "server-status-checker",
                url : urlparts[urlIndex],
                action : "process_server_status_checker_checker"
            },
            dataType: "json",
            error: function (error) {
                statuscodetr.find(".status_code").html(`<i class="las la-times-circle text-red"></i>`);
                statuscodetr.find(".status").html("Unknown");
            },
            success: function (response) {
                if( response.success ){
                    statuscodetr.find(".status_code").html(response.code);
                    statuscodetr.find(".status").html(response.remark);
                }else{
                    statuscodetr.find(".status_code").html(`<i class="las la-times-circle text-red"></i>`);
                    statuscodetr.find(".status").html(response.message);
                }
            },
            complete : function(){
                window.setTimeout(() => {
                    start_checking_statuscode(urlIndex + 1);
                }, 1000);
            }
        });
    }

    function get_urls_limit(){
        try {
            return parseInt(allsmarttools.user.plan.meta.urlnums);
        } catch (error) {
            
        }
        return false;
    }

    $(document).on("submit", ".server_status_checker_submit_form", function (e) {
        e.preventDefault();

        const btn = $(this).find("#server_status_checker_btn");
        const outputEle = $(document).find(".server_status_checker_report");

        const urls = $(document).find("[name=urls]").val();
        urlparts = urls.split("\n").filter(l => l);
        urlparts = urlparts.filter((item, i, ar) => ar.indexOf(item) === i);

        const urlLimit = get_urls_limit();
        if( urlLimit ){
            if( urlparts.length > urlLimit ){
                purchaseSubscriptionModal(`You are only allowed to check upto ${urlLimit} URLs in one request. Please upgrade the plan to use more URLs.`);
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: $(this).serializeArray(),
            dataType: "json",
            error: function (error) {
                btn.attr("disabled", true);
                show_loadingModal("Preparing URLs . . .");
            },
            success: function (response) {
                if( response.success ){
                    outputEle.closest(".form-group").removeClass("d-none");
                    const serverstatustbody = $(document).find(".server_status_checker_report table tbody");
                    serverstatustbody.html("");
                    $(document).find("#server_status_checker_btn").attr("disabled", true);
                    for(let i = 0; i < urlparts.length; i++){
                        serverstatustbody.append(`<tr class="status_code_${i}_checking">
                            <td class="text-center">${i+1}</td>
                            <td>${urlparts[i]}</td>
                            <td class="status_code text-center"><div class="spinner-grow spinner-grow-sm text-muted"></div></td>
                            <td class="status text-center"><div class="spinner-grow spinner-grow-sm text-muted"></div></td>
                        </tr>`);
                    }
                    
                    start_checking_statuscode(0);
                }else{
                    alertMessage("error", response.message);
                }
            },
            complete : function(){
                reloadv3_captcha();
                hide_loadingModal();
            }
        });
        return true;
    });
});