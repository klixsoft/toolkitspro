$(document).ready(function() {
    let linkArray = [];
    let createURL = "";
    const backlinkreport = $(document).find(".backlink_maker_report");
    const progress = backlinkreport.find(".progress-bar");

    function setProgressPer(domainIndex) {
        const value = Math.round((domainIndex / linkArray.length) * 100);
        progress.css({
            width: `${value}%`
        });
        progress.attr("aria-valuenow", value);
        progress.text(`${value}%`)
    };

    function cleanURL() {
        const url = new URL(createURL);
        createURL = url.hostname;
        return true
    };

    function startCreatingBacklink(domainIndex) {
        setProgressPer(domainIndex);
        if (domainIndex >= linkArray.length) {
            setProgressPer(linkArray.length);
            $(document.body).trigger("has_message", {
                type: "success",
                messages: [linkArray.length + " Backlinks Created Successfully!!!"]
            });
            return
        }
        const trEle = backlinkreport.find(`#backlink_maker_${domainIndex}_index`);
        backlinkreport.find(".tbl-content").animate({
            scrollTop: trEle.position().top
        }, 100);
        const c_link = linkArray[domainIndex].replace('{host}', createURL);

        let submitData = {
            action: "process_create_backlink",
            url: c_link,
            tool: "backlink-maker"
        };

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: submitData,
            dataType: "json",
            beforeSend: function() {
                trEle.find(".status").html(`<div class="spinner-border spinner-border-sm text-muted"></div>`)
            },
            error: function(error) {
                trEle.find(".status").html(`<i class="las la-times-circle"></i>`)
            },
            success: function(response) {
                if (response.success) {
                    trEle.find(".status").html(`<i class="las la-check-circle"></i>`)
                } else {
                    trEle.find(".status").html(`<i class="las la-times-circle"></i>`)
                }
            },
            complete: function() {
                window.setTimeout(() => {
                    startCreatingBacklink(domainIndex + 1)
                }, 1000)
            }
        })
    };

    $(document).on("submit", ".backlink-maker_submit_form", function(e) {
        e.preventDefault();
        createURL = $(this).find("input[name=link]").val();
        if (cleanURL()) {
            jQuery.get(allsmarttools.siteurl + 'tools/backlink-maker/backlink.dat', function(data) {
                linkArray = data.split('\n');
                if (linkArray.length < 2) {
                    $(document.body).trigger("has_message", {
                        type: "danger",
                        messages: ["Unable to Create Backlink. Please try again!!!"]
                    });
                    return
                }
                const backlinkcontent = backlinkreport.find(".tbl-content tbody");
                backlinkcontent.html("");
                backlinkreport.closest(".form-group").removeClass("d-none");
                for (let i = 0; i < linkArray.length; i++) {
                    const replaceurl = linkArray[i].replace('{host}', createURL);
                    backlinkcontent.append(`<tr id="backlink_maker_${i}_index"><td>${i+1}</td><td><a href="${replaceurl}"target="_blank">${replaceurl}</a></td><td class="status"><div class="spinner-grow spinner-grow-sm text-muted"></div></td></tr>`)
                }
                startCreatingBacklink(0)
            });
        }
    })
});