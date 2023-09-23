$(document).ready(function() {
    $(document).on("click", ".add_new_directory_row", function() {
        const container = $(document).find(".directory_template_container");
        container.append(`<div class="col-md-12 mt-3"><div class="input-group"><input type="text"class="form-control"><div class="input-group-append"><span style="cursor:pointer;"class="input-group-text"><i class="las la-times"></i></span></div></div></div>`)
    });
    
    $(document).on("click", ".directory_template_container .input-group-append", function() {
        const container = $(document).find(".directory_template_container");
        if (container.find(".input-group").length > 1) {
            const ele = $(this).closest(".col-md-12");
            ele.slideUp("slow", function() {
                ele.remove()
            })
        }
    });

    function generate_robots_txt() {
        let robotstxt = '';
        $(document).find(".search_robots_containers select").each(function() {
            const value = $(this).val() || "default";
            if (value != "default") {
                const agentvalue = (value == 'allow') ? '' : '/';
                robotstxt += `User-agent:${$(this).attr('data-agent')}\nDisallow:${agentvalue}\n`
            }
        });
        const defaultallow = $(document).find('input[name=allow]').val() || "";
        robotstxt += "User-agent: *\nDisallow:" + defaultallow + "\n";
        const crawldelay = $(document).find('input[name=delay]').val() || "default";
        if (crawldelay && crawldelay != 'default') {
            robotstxt += "Crawl-delay: " + crawldelay + "\n"
        }
        const sitemap = $(document).find('input[name=sitemap]').val() || "";
        if (sitemap && sitemap.length > 0) {
            robotstxt += "Sitemap: " + sitemap + "\n"
        }
        $(document).find(".directory_template_container input").each(function() {
            const value = $(this).val() || "";
            if (value && value.length > 0) {
                robotstxt += `Disallow:${value}\n`
            }
        });
        $(document).find("#robots_txt_generator_result").val(robotstxt)
    };

    $(document).on("change", ".backlink_maker_submit_form select", function() {
        generate_robots_txt()
    });

    $(document).on("change keypress keydown paste", ".backlink_maker_submit_form input", function() {
        generate_robots_txt()
    });

    $(document).on("click", ".robots_txt_generator_copy", function() {
        const val = $(document).find("#robots_txt_generator_result").val();
        $(document.body).trigger("clear_message");
        if (val && val.length > 0) {
            copy_text(val);
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            alertMessage("error" , "Robots.txt is empty. Change some value to generate robots.txt!!!");
        }
    });
    $(document).on("click", ".robots_txt_generator_download", function() {
        const val = $(document).find("#robots_txt_generator_result").val();
        if (val && val.length > 0) {
            download_text(val, "robots.txt");
            $(this).addClass("active");
            setTimeout(() => {
                $(this).removeClass("active")
            }, 1000)
        } else {
            alertMessage("error", "Robots.txt is empty. Change some value to generate robots.txt!!!");
        }
    })
});