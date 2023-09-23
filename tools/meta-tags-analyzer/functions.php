<?php

function ast_analyze_meta_tags( $url ){
    
    $title = $description = $keywords = $html = $author = $siteName = $robots = '';
    $viewport = '-';
    $lenTitle = $lenDes = 0;
    $openG = false;
    
    //Get Data of the URL
    $html = getRequest($url);
    
    if($html == '')
        return false;
    
    //Fix Meta Uppercase Problem
    $html = str_ireplace(array("Title","TITLE"),"title",$html);
    $html = str_ireplace(array("Description","DESCRIPTION"),"description",$html);
    $html = str_ireplace(array("Keywords","KEYWORDS"),"keywords",$html);
    $html = str_ireplace(array("Content","CONTENT"),"content",$html);  
    $html = str_ireplace(array("Meta","META"),"meta",$html);  
    $html = str_ireplace(array("Name","NAME"),"name",$html);      
    
    //Load the document and parse the meta     
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');
    $title = $nodes->item(0)->nodeValue;
    $metas = $doc->getElementsByTagName('meta');

    $metaArray = array();
    foreach ($metas as $meta) {
        $name = $meta->getAttribute('name');
        $content = $meta->getAttribute('content');
        if (!empty($name) && !empty($content)) {
            $metaArray[$name] = $content;
        }
    }

    foreach($metaArray as $key => $value){
        if($key == 'description')
            $description = $value;
        if($key == 'keywords')
            $keywords = $value;
        if($key == 'viewport')
            $viewport = $value;
        if($key == 'robots')
            $robots = $value; 
        if($key == 'author')
            $author = $value;   
        if($key == 'site_name')
            $siteName = $value;   
        if($key == 'og:title')
            $openG = true;
    }
    
    return (object) array(
        "url" => $url,
        "title" => $title,
        "desc" => $description, 
        "keywords" => $keywords, 
        "robots" => $robots,
        "isindex" => empty( $robots ) ? true : (strpos($robots, "index") !== false),
        "openg" => $openG, 
        "viewport" => $viewport, 
        "author" => $author, 
        "sitename" => $siteName
    );
}

/** RENDER TOOL TEMPLATE */
add_action("ast_tool_content_meta-tags-analyzer", "ast_render_meta_tag_analyze_tool_content", 10, 2);
function ast_render_meta_tag_analyze_tool_content($tool, $report){
    echo \AST\Helper\Downloader::template($tool, $report, "Enter URL", array(
        "btnlabel" => "Analyze Meta Tags",
        "name" => "url",
        "loadingmodal" => "Analyzing Meta Tags . . .",
        "resultlabel" => "Result"
    ));
}

/** INCLUDE TOOL SCRIPTS */
add_action("add_scripts", "include_mta_scripts");
function include_mta_scripts(){
    add_js_script("toolscript", get_site_url("app/templates/downloader/main.js"));
    add_code_before_script("toolscript", 'const toolOptions={errormessage : "Unable to analyze URL. Please check URL and try again!!!"};');
}

/** HANDLE AJAX REQUEST */
add_action("ajax/req/process_meta-tags-analyzer_checker", "ast_process_meta_analyzer");
add_action("ajax/req/nologin/process_meta-tags-analyzer_checker", "ast_process_meta_analyzer");
function ast_process_meta_analyzer(){
    $output = array();
    if( isset( $_POST['url'] ) && filter_var( $_POST['url'], FILTER_VALIDATE_URL ) ){
        $response = ast_analyze_meta_tags(trim($_POST['url']));
        if( $response ){
            
            ob_start();
            include TOOLS_PATH . "meta-tags-analyzer/result.php";
            $output = array(
                "success" => true,
                "message" => ob_get_clean()
            );
            
        }else{
            $output = array(
                "success" => false,
                "message" => "Unable to Analyze URL. Please try again!!!"
            );
        }
    }else{
        $output = array(
            "success" => false,
            "message" => "Enter a valid URL!!!"
        );
    }

    echo json_encode( $output );
    die();
}
