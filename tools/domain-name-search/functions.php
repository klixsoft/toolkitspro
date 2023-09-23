<?php

/** RENDER TOOL CONTENT */
add_action("ast_tool_content_domain-name-search", function($tool, $report){
    echo '<style>
        .domain_extension_domain {
            position: absolute;
            left: -93px;
            top: 13px;
            z-index: 9;
            cursor:pointer;
        }
        
        .domain_extension_domain select,
        .domain_extension_domain select:focus,
        .domain_extension_domain select:active {
            padding: 0;
            outline: none;
            box-shadow: none;
            border-radius: 5px;
            border: none !important;
            background: #dedede !important;
            color: #000;
            padding: 5px 10px;
        }
    </style>';
    echo \AST\Helper\Downloader::template($tool, $report, "Enter Keyword", array(
        "btnlabel" => "Search Domains",
        "placeholder" => "Enter a Keyword",
        "copy" => "hide",
        "before_btn" => '<div class="domain_extension_domain">
            <select name="extension">
                <option value="com">.com</option>
                <option value="net">.net</option>
                <option value="org">.org</option>
                <option value="net">.net</option>
                <option value="info ">.info</option>
                <option value="edu">.edu</option>
            </select>
        </div>',
        "name" => "query",
        "loadingmodal" => "Searching Domain . . ."
    ));
}, 10, 2);

/** INCLUDE TOOL SCRIPT */
add_action("add_scripts", "include_domain_name_checker_script", 100);
function include_domain_name_checker_script(){
    add_js_script("toolscript", get_site_url() . "app/templates/downloader/main.js");
    add_code_before_script("toolscript", sprintf("const toolOptions = %s;", json_encode(array(
        "loadingtext" => "Searching Domain . . .",
        "errormessage" => "Unable to search domains. Please check keyword and try again!!!"
    ))));
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_domain-name-search_checker", "ajax_process_domain_name_search");
add_action("ajax/req/nologin/process_domain-name-search_checker", "ajax_process_domain_name_search");
function ajax_process_domain_name_search(){
    if( isset( $_POST['query'] ) && !empty($_POST['query']) ){
        $valdation = validate_captcha();
        if( $valdation->success ){
            $ext = isset($_POST['extension']) && !empty($_POST['extension']) ? trim($_POST['extension']) : "com";
            include TOOLS_PATH . "domain-name-search/domainNameSearch.php";
            $result = (new \Tool\domainNameSearch($_POST['query'], $ext))->get();
            if( !empty( $result ) ){
                ob_start();
                include TOOLS_PATH . "domain-name-search/result.php";
                ast_send_json(array(
                    "success" => true,
                    "message" => ob_get_clean()
                ));
            }
            ast_send_json($result);
        }else{
            ast_send_json($valdation);
        }
    }else{
        ast_send_json(array(
            "success" => false,
            "message" => "Please provide valid Query!!!"
        ));
    }
}

/** ADDITIONAL SETTINGS */
add_action("ast/post/additional/settings", "ast_admin_yt_trend_settings", 10, 1);
function ast_admin_yt_trend_settings($tooldata){
    if( $tooldata->slug == 'domain-name-search' && $tooldata->type == 'tool' ){
        global $fields;
        $dnsCount = get_meta("tool", $tooldata->id, "suggestion_count", 20);
        $buynowlink = get_meta("tool", $tooldata->id, "buy_now_link");
        require_once TOOLS_PATH . "domain-name-search/settings.php";
    }
}