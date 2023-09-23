$(document).ready(function () {

    alertify.defaults.closable = false;
    alertify.defaults.transition = "slide";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.title = "Alert";
    alertify.defaults.notifier.position = "top-right";

    init({
        fade_in: 500,
        fade_out: 500,
        position: 'top-right'
    });

    window.alertMessage = (type, message, title = "Alert", timeout = 4000) => {
        toast({
            title: title,
            description: message,
            type: type,
            timeout: timeout,
            title: title
        });
    }


    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };

    let url = window.location.href;
    url = url.replace(/\/$/, "");
    try {
        let newurl = new URL(url);
        url = newurl.href;

        if (url.includes("edit")) {
            url = url.split("/edit/")[0];
        }
    } catch (error) {

    }


    let ele = $(document).find(`a[href='${url}']`);
    if (ele.length <= 0) {
        ele = $(document).find(`a[href='${url}/']`);
    }

    if (ele.length > 0) {
        ele.addClass("active");
        let parent = ele.closest("ul");
        if (parent.hasClass("nav-treeview")) {
            parent = parent.closest("li.nav-item");
            parent.addClass("menu-is-opening menu-open");
            parent.find(">:first-child").addClass("active");
        }
    }

    const colorpicker = $(document).find(".colorpicker");
    if (colorpicker.length > 0) {
        colorpicker.each(function () {
            let format = $(this).attr("data-format") || "hex";
            let opacity = $(this).attr("data-opacity") || "false";
            opacity = opacity == "true";

            $(this).minicolors({
                format: format,
                opacity: opacity
            });
        });
    }

    function strip_tags(str, allowed_tags) {

        var key = '', allowed = false;
        var matches = []; var allowed_array = [];
        var allowed_tag = '';
        var i = 0;
        var k = '';
        var html = '';
        var replacer = function (search, replace, str) {
            return str.split(search).join(replace);
        };
        // Build allowes tags associative array
        if (allowed_tags) {
            allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
        }
        str += '';

        // Match tags
        matches = str.match(/(<\/?[\S][^>]*>)/gi);
        // Go through all HTML tags
        for (key in matches) {
            if (isNaN(key)) {
                // IE7 Hack
                continue;
            }

            // Save HTML tag
            html = matches[key].toString();
            // Is tag not in allowed list? Remove from str!
            allowed = false;

            // Go through all allowed tags
            for (k in allowed_array) {            // Init
                allowed_tag = allowed_array[k];
                i = -1;

                if (i != 0) { i = html.toLowerCase().indexOf('<' + allowed_tag + '>'); }
                if (i != 0) { i = html.toLowerCase().indexOf('<' + allowed_tag + ' '); }
                if (i != 0) { i = html.toLowerCase().indexOf('</' + allowed_tag); }

                // Determine
                if (i == 0) {
                    allowed = true;
                    break;
                }
            }
            if (!allowed) {
                str = replacer(html, "", str); // Custom replace. No regexing
            }
        }
        return str;
    }

    /** Initialize Editor */
    if ($(document).find("#maineditor").length > 0) {
        tinymce.init({
            selector: '#maineditor',
            promotion: false,
            menubar: true,
            plugins: "paste codesample link media image code fullscreen table autolink advlist lists responsivefilemanager autoresize emoticons wordcount",
            toolbar: [
                'bold italic underline strikethrough | subscript superscript | list bullist numlist blockquote alignleft aligncenter alignright alignjustify autolink link table',
                'formatselect autolink forecolor |  subscript superscript | outdent indent | responsivefilemanager image media emoticons | wordcount codesample fullscreen code'
            ],
            image_advtab: false,

            external_filemanager_path: allsmarttools.adminurl + "assets/modules/filemanager/filemanager/",
            filemanager_title: "Filemanager",
            external_plugins: { "filemanager": allsmarttools.adminurl + "assets/modules/tinymce/plugins/responsivefilemanager/plugin.min.js" },
            relative_urls: false,
            remove_script_host: true,
            document_base_url: allsmarttools.siteurl,
            toolbar_sticky: true,
            image_dimensions: false,
            image_class_list: [
                {
                    title: 'Responsive',
                    value: 'img-responsive'
                }
            ],
            paste_preprocess: function (pl, o) {
                o.content = strip_tags(o.content, '<h1><h2><h3><h4><h5><h6><span><b><u><i><p><strong><ul><li><pre><code><small><sup><sub><img><a><ol><table><thead><tbody><tr><td><th><tfoot><col><colgroup>');
                const regex = /(?:<style>((?:.*?\r?\n?)*)<\/style>)+|(?:<script>((?:.*?\r?\n?)*)<\/script>)+|(style=\"[^\"]*\")/g;
                o.content = o.content.replace(regex, "");
            },
            table_class_list: [
                { title: 'Table Bordered', value: 'table table-bordered' },
                { title: 'None', value: '' }
            ],
            noneditable_noneditable_class: 'alert'
        });
    }

    $(document).on("click", ".image_fill_placeholder i", function () {
        const ele = $(this).closest(".image_picker_container");
        if (ele && ele.length > 0) {
            ele.removeClass("added");
            ele.find(".image_fill_placeholder").remove();
            ele.find("input").val("").trigger("change");
        }
    });

    window.responsive_filemanager_callback = (field_id) => {
        const featuredid = $(document).find("#" + field_id);
        if (featuredid.length > 0) {
            const ele = featuredid.closest(".image_picker_container");
            if (ele && ele.length > 0) {
                ele.addClass("added");
                ele.append(`<div class="image_fill_placeholder">
                        <i class="las la-times"></i>
                        <img src="${featuredid.val()}" alt="PreView Image" />
                    </div>`);
            }
        }
    }

    const fancyboxfile = $(document).find(".openImagePicker");
    if (fancyboxfile.length > 0) {
        fancyboxfile.fancybox({
            'width': 900,
            'height': 600,
            'type': 'iframe',
            'autoScale': true
        });
    }

    const tagify = $(document).find(".tagin");
    if (tagify.length > 0) {
        for (const el of document.querySelectorAll('.tagin')) {
            new Tagin(el, {
                separator: ' , ',
                duplicate: false,
                enter: true
            });
        }
    }

    const selectcategory_select = $(document).find(".selectcategory_select");
    if (selectcategory_select.length > 0) {
        selectcategory_select.select2({
            placeholder: 'Select Category',
            ajax: {
                url: allsmarttools.ajaxurl,
                type: "POST",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term,
                        action: "get_category_ajax",
                        typeof: selectcategory_select.attr("data-type")
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    const select_author = $(document).find("#select_author");
    if (select_author.length > 0) {
        select_author.select2({
            placeholder: 'Select Author',
            ajax: {
                url: allsmarttools.ajaxurl,
                type: "POST",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term,
                        action: "get_user_details"
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    const select_tools = $(document).find(".select_tools");
    if (select_tools.length > 0) {
        select_tools.select2({
            placeholder: 'Select Tools',
            ajax: {
                url: allsmarttools.ajaxurl,
                type: "POST",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term,
                        action: "get_tool_details"
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    const tabledatatable = $(document).find(".table-datatable");
    if (tabledatatable.length > 0) {

        const columnsdisable = [];
        tabledatatable.find("thead th").each(function () {
            if ($(this).hasClass("no-sort")) {
                columnsdisable.push($(this).index());
            }
        });

        tabledatatable.DataTable({
            lengthChange: true,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: allsmarttools.ajaxurl,
                type: "POST",
                data: {
                    action: tabledatatable.attr("data-action")
                },
                dataType: "json"
            },
            aoColumnDefs: [
                { "bSortable": false, "aTargets": columnsdisable },
                { "bSearchable": false, "aTargets": columnsdisable }
            ]
        });
    }


    $(document.body).on("clear_message", function (e, data) {
        const errorcontainer = $(document).find(".has_messages");
        if (errorcontainer.length > 0) {
            errorcontainer.html('');
        }
    });

    $(document.body).on("has_message", function (e, data) {
        const errorcontainer = $(document).find(".has_messages");
        if (errorcontainer.length > 0) {
            errorcontainer.html('');

            let errormessages = ``;
            Promise.all(data?.messages?.map((message) => {
                errormessages += `<li>${message}</li>`;
            })).then(() => {
                errorcontainer.append(`<div class="alert alert-${data?.type || 'info'}" role="alert"><ul>${errormessages}</ul></div>`);
            });
        }
    });

    $(document).on("click", ".updateRobots", function () {
        const btn = $(this);
        const prevhtml = btn.html();
        const robotsContent = $(document).find(".robotsContent").val();
        if (robotsContent.length <= 0) {
            alertMessage('error', "Your Robots.txt file is empty!!!");
            return false;
        }

        alertify.confirm('Confirm', "Are you sure want to change robots.txt file?", function () {
            $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: {
                    action: "update_robots_txt",
                    content: robotsContent
                },
                dataType: "json",
                beforeSend: function () {
                    btn.attr("disabled", true).html('<i class="las la-spinner la-spin"></i> Updating . . .');
                },
                error: function (error) {
                    alertMessage('error', 'Unable to update robots.txt file!!!');
                },
                success: function (response) {
                    alertMessage(response.type, response?.message);
                },
                complete: function () {
                    btn.attr("disabled", false).html(prevhtml);
                }
            });
        }, function () {

        });
    });

    $(document).on("click", ".deletedatafromdb", function () {
        const btn = $(this);
        const prevhtml = btn.html();
        const from = btn.attr("data-from");
        const deleteid = parseInt(btn.attr("data-id"));

        if (from?.length > 0 && deleteid > 0) {
            alertify.confirm('Confirm', "This process is irreversible. Are you sure want to delete this data?", function () {
                $.ajax({
                    type: "POST",
                    url: allsmarttools.ajaxurl,
                    data: {
                        action: "delete_data_from_db",
                        delete_from: from,
                        delete_id: deleteid
                    },
                    dataType: "json",
                    beforeSend: function () {
                        btn.attr("disabled", true).html('<i class="las la-spinner la-spin"></i>');
                    },
                    error: function (error) {
                        alertMessage('error', 'Unable to Delete data from database!!!');
                    },
                    success: function (response) {
                        if (response.success) {
                            alertMessage('success', response?.message);
                            btn.closest("tr").fadeOut("slow", function () {
                                btn.closest("tr").remove();
                            });
                        } else {
                            alertMessage('error', response?.message);
                            btn.attr("disabled", false).html(prevhtml);
                        }
                    }
                });
            }, function () {

            });
        } else {
            alertMessage('error', 'Unable to Delete data from database!!!');
        }
    });

    $(document).on("submit", ".post_submit_form", function (e) {
        e.preventDefault();
        const form = $(this);
        const publishbtntext = form.find(".publishbtn").html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend: function () {
                $(document.body).trigger("clear_message");
                form.find(".publishbtn").attr("disabled", true).html("Publising . . .");
                form.find(".draftbtn").attr("disabled", true);
            },
            error: function (error) {
                alertMessage("error", "Unable to Update. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    if (response?.url) {
                        alertify.alert(response.message, function () {
                            window.location.href = response?.url || window.location.href;
                        });
                    } else {
                        alertMessage("success", response.message);
                    }
                } else {
                    alertMessage("error", response.message);
                }
            },
            complete: function () {
                form.find(".publishbtn").attr("disabled", false).html(publishbtntext);
                form.find(".draftbtn").attr("disabled", false);
            }
        });
    });

    $(document).on("submit", ".add_category_form", function (e) {
        e.preventDefault();
        const form = $(this);
        const publishbtn = form.find(".updatecategory");
        const publishbtntext = publishbtn.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend: function () {
                publishbtn.attr("disabled", true).html("Publising . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to Update. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertify.alert(response.message, function () {
                        window.location.href = response?.url || window.location.href;
                    });
                } else {
                    alertMessage('error', response.message);
                }
            },
            complete: function () {
                publishbtn.attr("disabled", false).html(publishbtntext);
            }
        });
    });

    $(document).on("click", ".buildAdminSitemap", function (e) {
        e.preventDefault();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "generate_admin_sitemap"
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Generating . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to Generate. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage('success', response.message);
                } else {
                    alertMessage('error', response.message);
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });

    const onChangeDisable = $(document).find(".onChangeDisable");
    if (onChangeDisable.length > 0) {
        onChangeDisable.each(function () {
            const target = $(this).attr("data-tag");
            if (target) {
                const targetEle = $(document).find(`.${target}`);
                if (targetEle.length > 0) {
                    if ($(this).attr("type") == 'input') {
                        if ($(this).val().length > 0) {
                            targetEle.attr("disabled", true);
                        } else {
                            targetEle.attr("disabled", false);
                        }
                    } else if ($(this).attr("type") == 'checkbox') {
                        if ($(this).is(":checked")) {
                            targetEle.attr("disabled", false);
                        } else {
                            targetEle.attr("disabled", true);
                        }
                    }
                }
            }
        });
    }

    $(document).on("change", ".onChangeDisable", function () {
        const target = $(this).attr("data-tag");
        if (target) {
            const targetEle = $(document).find(`.${target}`);
            if (targetEle.length > 0) {
                if ($(this).attr("type") == 'input') {
                    if ($(this).val().length > 0) {
                        targetEle.attr("disabled", true);
                    } else {
                        targetEle.attr("disabled", false);
                    }
                } else if ($(this).attr("type") == 'checkbox') {
                    if ($(this).is(":checked")) {
                        targetEle.attr("disabled", false);
                    } else {
                        targetEle.attr("disabled", true);
                    }
                }
            }
        }
    });

    function validate_form(ele) {
        let valid = true;
        ele.find("input").each(function () {
            if ($(this).prop('required') && !$(this).prop("disabled")) {
                if ($(this).attr("type") == 'checkbox' && !$(this).is(":checked")) {
                    alertMessage('error', $(this).attr("data-alert"));

                    valid = false;
                    return false;
                } else if ($(this).val().trim().length == 0) {
                    alertMessage('error', $(this).attr("data-alert"));

                    valid = false;
                    return false;
                }
            }
        });

        ele.find("textarea").each(function () {
            if ($(this).prop('required') && !$(this).prop("disabled")) {
                if ($(this).val().trim().length == 0) {
                    alertMessage('error', $(this).attr("data-alert"));

                    valid = false;
                    return false;
                }
            }
        });

        if (valid) {
            ele.addClass("valid");
        } else {
            ele.removeClass("valid");
        }

        return valid;
    }

    function convertStringToJSON(output, string, value) {
        var parts = string.split(/\[|\]/).filter(function (part) {
            return part !== '';
        });

        var currentObj = output;
        for (var i = 0; i < parts.length - 1; i++) {
            var part = parts[i];
            if (!currentObj[part]) {
                currentObj[part] = {};
            }
            currentObj = currentObj[part];
        }

        var key = parts[parts.length - 1];
        if (typeof key == "string") {
            currentObj[key] = value;
        }
    }

    function generate_data(ele) {
        let output = {};

        ele.find("input").each(function () {
            if ($(this).attr("type") == 'checkbox') {
                if ($(this).hasAttr("name")) {
                    convertStringToJSON(output, $(this).attr("name"), $(this).is(":checked"));
                }
            } else {
                if ($(this).hasAttr("name")) {
                    convertStringToJSON(output, $(this).attr("name"), $(this).val());
                }
            }
        });

        console.log(output);

        ele.find("textarea").each(function () {
            if ($(this).hasAttr("name")) {
                convertStringToJSON(output, $(this).attr("name"), $(this).val());
            }
        });

        ele.find("select").each(function () {
            if ($(this).hasAttr("name")) {
                convertStringToJSON(output, $(this).attr("name"), $(this).find(":selected").val());
            }
        });
        return output;
    }

    $(document).on("click", ".updateRouteSettings", function (e) {
        e.preventDefault();

        e.preventDefault();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        const form = $(document).find(".settings_form");
        if (validate_form(form)) {
            const rawData = generate_data(form);
            $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: rawData,
                dataType: "json",
                beforeSend: function () {
                    btnEle.attr("disabled", true).html("Updating . . .");
                },
                error: function (error) {
                    alertMessage("error", "Unable to update permalinks. Please try again!!!");
                },
                success: function (response) {
                    if (response.success) {
                        alertMessage("success", response.message);
                        setTimeout(() => {
                            window.location.href = window.location.href;
                        }, 2000);
                    } else {
                        alertMessage("error", response.message);
                    }
                },
                complete: function () {
                    btnEle.attr("disabled", false).html(prevHTML);
                }
            });
        }
    });

    $(document).on("click", ".updateAPIKeys", function (e) {
        e.preventDefault();

        const btnEle = $(this);
        const prevHTML = btnEle.html();

        const form = $(document).find(".settings_form");
        if (validate_form(form)) {
            let rawSettings = {};
            $(document).find(".api_keys_lists input").each(function () {
                if ($(this).attr("type") == "checkbox") {
                    rawSettings[$(this).attr("name")] = $(this).is(":checked");
                } else if ($(this).attr("type") == "radio") {
                    rawSettings[$(this).attr("name")] = $(this).find(":checked").val();
                } else {
                    rawSettings[$(this).attr("name")] = $(this).val();
                }
            });

            $(document).find(".api_keys_lists textarea").each(function () {
                rawSettings[$(this).attr("name")] = $(this).val();
            });

            $(document).find(".api_keys_lists select").each(function () {
                rawSettings[$(this).attr("name")] = $(this).find(":selected").val();
            });

            $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: {
                    action: "update_site_settings",
                    dataof: "toolapikeys",
                    settings: rawSettings
                },
                dataType: "json",
                beforeSend: function () {
                    btnEle.attr("disabled", true).html("Updating . . .");
                },
                error: function (error) {
                    alertMessage("error", "Unable to Generate. Please try again!!!");
                },
                success: function (response) {
                    if (response.success) {
                        alertMessage("success", response.message);
                    } else {
                        alertMessage("error", response.message);
                    }
                },
                complete: function () {
                    btnEle.attr("disabled", false).html(prevHTML);
                }
            });
        }
    });

    $(document).on("click", ".updateSettings", function (e) {
        e.preventDefault();

        const btnEle = $(this);
        const prevHTML = btnEle.html();

        const form = $(document).find(".settings_form");
        if (validate_form(form)) {
            const rawData = generate_data(form);

            $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: {
                    action: "update_site_settings",
                    dataof: $(this).attr("data-key"),
                    settings: rawData
                },
                dataType: "json",
                beforeSend: function () {
                    btnEle.attr("disabled", true).html("Updating . . .");
                },
                error: function (error) {
                    alertMessage("error", "Unable to Generate. Please try again!!!");
                },
                success: function (response) {
                    if (response.success) {
                        alertMessage("success", response.message);
                    } else {
                        alertMessage("error", response.message);
                    }
                },
                complete: function () {
                    btnEle.attr("disabled", false).html(prevHTML);
                }
            });
        }
    });

    $(document).on("click", ".manualMinification", function (e) {
        e.preventDefault();

        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "manual_minification"
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Minification . . .");
            },
            error: function (error) {
                alertMessage("error", "Unable to minifiy scripts. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage("success", response.message);
                } else {
                    alertMessage("error", response.message);
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });

    $(document).on("click", ".send_user_reset_password_link", function (e) {
        e.preventDefault();

        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "send_user_reset_password_link",
                userid: $(this).attr("data-id")
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.html("Sending . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to Send reset Password Link. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage('success', response.message);
                } else {
                    alertMessage('error', response.message);
                }
            },
            complete: function () {
                btnEle.html(prevHTML);
            }
        });
    });

    $(document).on("click", ".send_user_email_activation_link", function (e) {
        e.preventDefault();

        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "send_user_email_activation_link",
                userid: $(this).attr("data-id")
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.html("Sending . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to Send Email Activation Link. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage('success', response.message);
                } else {
                    alertMessage('error', response.message);
                }
            },
            complete: function () {
                btnEle.html(prevHTML);
            }
        });
    });

    const sortable = $(document).find('ol.sortable');
    if (sortable.length > 0) {
        sortable.nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 2,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false
        });
    }

    $(document).on('click', '.disclose', function () {
        $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
        $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
    });

    $(document).on('click', '.expandEditor, .itemTitle', function () {
        var id = $(this).attr('data-id');
        $(document).find('#menuEdit' + id).toggle();
        $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
    });

    $(document).on("click", ".deleteMenu", function () {
        if (confirm("Are you sure want to delete?")) {
            var id = $(this).attr('data-id');
            $(document).find('#menuItem_' + id).remove();
        }
    });

    $(document).on("click", ".addNewMenuItem", function (e) {
        e.preventDefault();

        const form = $(this).closest(".add_menu_item_form");
        const menus_sort_container = $(document).find(".menus_sort_container ol.sortable");
        const title = form.find('input[name=title]').val();
        const link = form.find('input[name=link]').val();

        if (title && link) {
            let length = menus_sort_container.find("li").length + 1;
            menus_sort_container.append(`<li class="mjs-nestedSortable-leaf" id="menuItem_${length}">
                <div class="menuDiv">
                    <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"><span></span></span>
                    <span title="Click to show/hide item editor" data-id="${length}"class="expandEditor ui-icon ui-icon-triangle-1-s"><span></span></span>
                    <span>
                        <span data-id="${length}" class="itemTitle">${title}</span>
                        <span title="Click to delete item." data-id="${length}" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span>
                    </span>
                    <div id="menuEdit${length}" class="menuEdit hidden" style="display:none;">
                        <div class="p-2">
                            <div class="form-group mb-2">
                                <label>Title</label>
                                <input type="text" class="title form-control" value="${title}" />
                            </div>

                            <div class="form-group mb-0">
                                <label>Link</label>
                                <input type="text" class="link form-control" value="${link}" />
                            </div>
                        </div>
                    </div>
                </div>
            </li>`);
            form.find('input[name=title]').val("");
            form.find('input[name=link]').val("");
        }
    });

    $(document).on("change keyup keydown", ".menuEdit input.title", function () {
        const ele = $(this).closest(".menuDiv");
        if (ele.length > 0) {
            ele.find(".itemTitle").html($(this).val());
        }
    });

    function generate_menus_data(ele) {
        let output = {};
        ele.find(" > li").each(function () {
            let id = $(this).attr("id").toString().toLowerCase();
            if ($(this).hasClass("mjs-nestedSortable-branch")) {
                output[id] = {
                    title: $(this).find("input.title").val(),
                    link: $(this).find("input.link").val(),
                    child: generate_menus_data($(this).find("ol"))
                };
            } else {
                output[id] = {
                    title: $(this).find("input.title").val(),
                    link: $(this).find("input.link").val(),
                    child: []
                };
            }
        });
        return output;
    }

    $(document).on("click", ".updateMenuSettings", function (e) {
        e.preventDefault();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        const ele = $(document).find(".menus_sort_container ol.sortable");
        const data = generate_menus_data(ele);
        if (Object.keys(data).length === 0) {
            alertMessage('error', "Unable to update menus because menu is empty!!!");
            return;
        }

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "update_site_settings",
                dataof: $(this).attr("data-save"),
                settings: data
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Updating . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to update menus. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage('success', "Menus Updated Successfully!!!");
                } else {
                    alertMessage('error', "Unable to update menus. Please try again!!!");
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });

    $(document).on("click", ".updateColumnsSettings", function (e) {
        e.preventDefault();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        let data = {};
        $(document).find(".footer_columns .card").each(function () {
            let temp = {};

            $(this).find("textarea, input").each(function () {
                temp[$(this).attr("name")] = $(this).val();
            });

            $(this).find("select").each(function () {
                temp[$(this).attr("name")] = $(this).find(":selected").val();
            });

            data[$(this).attr("data-id")] = temp;
        });

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "update_site_settings",
                dataof: "footercolumns",
                settings: data
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Updating . . .");
            },
            error: function (error) {
                alertMessage('error', "Unable to update footer columns. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage('success', "Footer Columns Updated Successfully!!!");
                } else {
                    alertMessage('error', "Unable to update footer columns. Please try again!!!");
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });


    $(document).on("click", ".removePluginBtn", function (e) {
        e.preventDefault();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "remove_plugins",
                plugin: $(this).attr("data-plugin")
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Removing . . .");
            },
            error: function (error) {
                alertMessage("error", "Unable to remove. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage("success", "Plugin Removed Successfully!!!");
                    setTimeout(() => {
                        window.location.href = window.location.href;
                    }, 1000);
                } else {
                    alertMessage("error", "Unable to remove Plugin. Please try again!!!");
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });


    $(document).on("change", ".footer_columns [name=type]", function () {
        const value = $(this).find(":selected").val();
        if (footercolumntemplate.hasOwnProperty(value)) {
            const card = $(this).closest(".card");
            let htmlTemplate = footercolumntemplate[value];
            if (value == "menu") {
                htmlTemplate = htmlTemplate.replace(/footer_column_/g, `footer_column_${card.attr("data-id")}`);
                htmlTemplate = htmlTemplate.replace(/Footer Column Menu/g, `Footer Column ${card.attr("data-id")} Menu`);
            }
            card.find(".card-body").html(htmlTemplate);
        }
    });


    function toggleSMTPProtocol() {
        const mailprotocol = $(document).find(".mail_settings_form [name=protocol]").find(":selected").val();
        if (mailprotocol == 'default') {
            $(document).find(".smtp_information").slideUp();
        } else {
            $(document).find(".smtp_information").slideDown();
        }
    }
    $(document).on("change", ".mail_settings_form [name=protocol]", function () {
        toggleSMTPProtocol();
    });

    if ($(document).find(".mail_settings_form [name=protocol]").length > 0) {
        toggleSMTPProtocol();
    }

    $(document).on("click", ".faq_single .removeBtn", function () {
        $(this).closest(".faq_single").slideUp("normal", function () {
            $(this).remove();
        });
    });

    $(document).on("click", ".addFaqQuestion", function () {
        const faqEle = $(document).find(".faq_question_container");
        let index = -1;
        if (faqEle.find(".faq_single").length > 0) {
            index = parseInt(faqEle.find(".faq_single:last-child").attr("data-index"));
        }
        index = index + 1;

        faqEle.append(`<div class="form-group faq_single" data-index="${index}">
            <div class="input-group mb-2">
                <input type="text" required class="form-control" placeholder="Question . . ." value="" name="meta[faqQuestions][${index}][qn]" aria-label="Question" aria-describedby="faqRemoveBtn${index}">
                <span class="input-group-text removeBtn" id="faqRemoveBtn${index}">-</span>
            </div>
            <textarea type="text" required placeholder="Answer . . ." row="4" class="form-control" name="meta[faqQuestions][${index}][ans]"></textarea>
        </div>`);
    });

    $(document).on("click", ".schema_single .removeBtn", function () {
        $(this).closest(".schema_single").slideUp("normal", function () {
            $(this).remove();
        });
    });

    $(document).on("click", ".addNewSchemaStep", function () {
        const schemaEle = $(document).find(".schema_container");
        let index = -1;
        if (schemaEle.find(".schema_single").length > 0) {
            index = parseInt(schemaEle.find(".schema_single:last-child").attr("data-index"));
        }
        index = index + 1;
        const filemanagerurl = schemaEle.attr("data-filemanager") + index;

        schemaEle.append(`<div class="form-group schema_single" data-index="${index}">
            <div class="input-group mb-2">
                <input type="text" required class="form-control" placeholder="Step Title . . ." name="meta[schema_steps_data][${index}][title]" aria-label="Question" aria-describedby="schemaRemoveBtn${index}">
                <input type="text" required id="stepImageInput${index}" class="form-control" placeholder="Step Image . . ." name="meta[schema_steps_data][${index}][image]" aria-label="Question" aria-describedby="uploadSchemaImageBtn${index}">
                <a class="btn btn-outline-secondary rounded-0 border select_featured_image_url openImagePicker" type="button" href="${filemanagerurl}" id="uploadSchemaImageBtn${index}"><i class="las la-image"></i></a>
                <span class="input-group-text removeBtn" id="schemaRemoveBtn${index}">-</span>
            </div>
            <textarea type="text" required row="3" class="form-control" name="meta[schema_steps_data][${index}][desc]" placeholder="Step Description"></textarea>
        </div>`);

        $(document).find(`#uploadSchemaImageBtn` + index).fancybox({
            'width': 900,
            'height': 600,
            'type': 'iframe',
            'autoScale': true
        });
    });

    $(document).on("click", ".addNewPost", function () {
        const datatype = $(this).attr("data-type");
        if (datatype != "redirection") {
            window.location.href = allsmarttools.siteurl + "admin/" + datatype + "addd/";
        } else {
            $(document).find("#addNewRedirection").modal("show");
        }
    });

    $(document).on("click", ".addNewRedirectionBtn", function () {
        const url = $(document).find(".redirect_url").val();
        const rurl = $(document).find(".redirect_rurl").val();
        const type = $(document).find(".redirect_type").find(":selected").val();
        const checktype = $(document).find(".redirect_checktype").find(":selected").val();
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        if (url.length > 0 && rurl.length > 0) {
            $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: {
                    action: "add_redirection",
                    url: url,
                    rurl: rurl,
                    type: type,
                    checktype: checktype
                },
                dataType: "json",
                beforeSend: function () {
                    btnEle.attr("disabled", true).html("Adding . . .");
                },
                error: function (error) {
                    alertMessage("error", "Unable to add new redirection. Please try again!!!");
                },
                success: function (response) {
                    if (response.success) {
                        setTimeout(() => {
                            window.location.href = window.location.href;
                        }, 1000);
                        alertMessage("success", "Redirection Added Successfully!!!");
                    } else {
                        alertMessage("error", response.message);
                    }
                },
                complete: function () {
                    btnEle.attr("disabled", false).html(prevHTML);
                }
            });
        } else {
            alertMessage("error", "All Fields are required!!!");
        }
    });

    $(document).on("click", ".clearPaypalBtn", function () {
        const btnEle = $(this);
        const prevHTML = btnEle.html();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: {
                action: "clear_paypal_data"
            },
            dataType: "json",
            beforeSend: function () {
                btnEle.attr("disabled", true).html("Clearing . . .");
            },
            error: function (error) {
                alertMessage("error", "Unable to clear paypal data. Please try again!!!");
            },
            success: function (response) {
                if (response.success) {
                    alertMessage("success", "Paypal Data Successfully!!!");
                } else {
                    alertMessage("error", response.message);
                }
            },
            complete: function () {
                btnEle.attr("disabled", false).html(prevHTML);
            }
        });
    });

    $(document).on("change", ".ast-switch-input", function () {
        const parentEle = $(this).closest(".ast-toggle-container");
        if ($(this).is(":checked")) {
            parentEle.find("input[type=text]").val("on");
        } else {
            parentEle.find("input[type=text]").val("off");
        }
    });
});