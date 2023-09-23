$(document).ready(function() {
    let linkArray = [];
    let createURL = "";
    const blacklistreport = $(document).find(".blacklist_lookup_report");
    const progress = blacklistreport.find(".progress-bar");

    function setProgressPer(domainIndex) {
        const value = Math.round((domainIndex / linkArray.length) * 100);
        progress.css({
            width: `${value}%`
        });
        progress.attr("aria-valuenow", value);
        progress.text(`${value}%`)
    }

    function cleanURL() {
        const url = new URL(createURL);
        createURL = url.hostname;
        return true
    }

    function startCreatingblacklist(domainIndex, checkurl) {
        setProgressPer(domainIndex);
        if (domainIndex >= linkArray.length) {
            setProgressPer(linkArray.length);
            $(document.body).trigger("has_message", {
                type: "success",
                messages: [linkArray.length + " DNS Checked Successfully!!!"]
            });
            return
        }
        const trEle = blacklistreport.find(`#blacklist_lookup_${domainIndex}_index`);
        blacklistreport.find(".tbl-content").animate({
            scrollTop: trEle.position().top
        }, 100);
        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "process_create_blacklist",
                dns: linkArray[domainIndex],
                url: checkurl,
                tool: "blacklist-lookup"
            },
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
                    startCreatingblacklist(domainIndex + 1)
                }, 1000)
            }
        })
    }
    $(document).on("submit", ".video_downloader_form", function(e) {
        e.preventDefault();
        createURL = $(this).find("input[name=url]").val();
        if (cleanURL()) {
            jQuery.get(allsmarttools.siteurl + 'tools/blacklist-lookup/blacklist.dat', function(data) {
                linkArray = data.split('\n');
                if (linkArray.length < 2) {
                    $(document.body).trigger("has_message", {
                        type: "danger",
                        messages: ["Unable to Check Blacklist. Please try again!!!"]
                    });
                    return
                }
                const blacklistcontent = blacklistreport.find(".tbl-content tbody");
                blacklistcontent.html("");
                blacklistreport.closest(".form-group").removeClass("d-none");
                for (let i = 0; i < linkArray.length; i++) {
                    const replaceurl = linkArray[i];
                    blacklistcontent.append(`<tr id="blacklist_lookup_${i}_index"><td>${i+1}</td><td><a href="${replaceurl}"target="_blank">${replaceurl}</a></td><td class="status"><div class="spinner-grow spinner-grow-sm text-muted"></div></td></tr>`)
                }
                startCreatingblacklist(0, createURL)
            })
        }
    })
});