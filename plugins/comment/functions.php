<?php

add_action("ast/after/tool/descrition", "include_review_system_template", 10, 1);
add_action("ast/after/post/descrition", "include_review_system_template", 10, 1);
function include_review_system_template($post){
    $postID = $post->id;
    $enableReview = $post->type == 'tool';
    include ASTROOTPATH . "plugins/comment/template.php";
}

add_action("add_scripts", "toolkitspro_comments_scripts");
function toolkitspro_comments_scripts($config){
    $commentminjs = PLUGINS_PATH . "plugins/comment/assets/js/main.min.js";
    if( ! file_exists( $commentminjs ) ){
        $scriptjs = get_site_url() . "plugins/comment/assets/js/main.js";
    }else{
        $scriptjs = get_site_url() . "plugins/comment/assets/js/main.min.js";
    }

    $commentmincss = PLUGINS_PATH . "plugins/comment/assets/css/main.min.css";
    if( ! file_exists( $commentmincss ) ){
        $scriptcss = get_site_url() . "plugins/comment/assets/css/main.css";
    }else{
        $scriptcss = get_site_url() . "plugins/comment/assets/css/main.min.css";
    }

    add_js_script("commentjs", $scriptjs, true, array(
        "async" => "",
        "defer" => ""
    ));
    add_css_script("commentcss", $scriptcss);
}

/**
 * Get comment number
 */
function get_comments_number( $postid ){
    global $db;
    $db->where("post", $postid);
    $db->get("comments", null);
    return $db->count;
}

function get_comment_count_parent($id){
    global $db;
    $db->where("post", $id);
    $db->where("parent", "0");
    $db->get("comments", null);
    return $db->count;
}

function generate_star_rating($rating=5){
    $output = '<div class="rating_value">';

    if( $rating > 4 ){
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
    }else if( $rating > 3 ){
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star">★</label>';
    }else if( $rating > 2 ){
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
    }else if( $rating > 1 ){
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
    }else if( $rating > 0 ){
        $output .= '<label class="star checked">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
    } else {
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
        $output .= '<label class="star">★</label>';
    }

    return $output . '</div>';
}

function get_comment_template($args, $replyID){
    $role = $args['author']['role'];
                                        
    $color = "#009688";
    $icon = "user";
    if( strtolower($role) == 'editor' ){
        $color = "#f57242";
        $icon = "user-edit";
    }else if( strtolower($role) == 'administrator' ){
        $color = "#c90000";
        $icon = "user-shield";
    }
    
    $message = $args['message'];
    $title = strip_tags($message);
    $url = get_unknown_post_url($args['post']) . "#comment_" . $args['id'];
    
    $blinkCss = $args['blink'] ? "blinkcomment" : "";
    return sprintf('<div class="comment-main-level %s" id="comment-%d">
                <div class="comment-avatar">
                    <img src="%s" alt="%s | Tool Pro Kit">
                    <i style="background:%s;" class="las la-%s" title="%s"></i>
                </div>
                <div class="comment-box">
                    <div class="comment-head">
                        <div class="left_part">
                            <h6 class="comment-name mt-0">%s</h6>
                            <span title="%s">%s</span>
                            <input type="hidden" value="%s" />
                        </div>

                        <div class="right_part">
                            %s

                            <svg xmlns="http://www.w3.org/2000/svg" title="Reply this Discussion" class="replyBtn" viewBox="0 0 512 512"><path d="M205 34.8c11.5 5.1 19 16.6 19 29.2v64H336c97.2 0 176 78.8 176 176c0 113.3-81.5 163.9-100.2 174.1c-2.5 1.4-5.3 1.9-8.1 1.9c-10.9 0-19.7-8.9-19.7-19.7c0-7.5 4.3-14.4 9.8-19.5c9.4-8.8 22.2-26.4 22.2-56.7c0-53-43-96-96-96H224v64c0 12.6-7.4 24.1-19 29.2s-25 3-34.4-5.4l-160-144C3.9 225.7 0 217.1 0 208s3.9-17.7 10.6-23.8l160-144c9.4-8.5 22.9-10.6 34.4-5.4z"/></svg>
                            
                            <svg xmlns="http://www.w3.org/2000/svg" title="Share this Discussion" class="shareBtn" data-url="%s" data-title="%s" data-image="%s" viewBox="0 0 448 512"><path d="M352 224c53 0 96-43 96-96s-43-96-96-96s-96 43-96 96c0 4 .2 8 .7 11.9l-94.1 47C145.4 170.2 121.9 160 96 160c-53 0-96 43-96 96s43 96 96 96c25.9 0 49.4-10.2 66.6-26.9l94.1 47c-.5 3.9-.7 7.8-.7 11.9c0 53 43 96 96 96s96-43 96-96s-43-96-96-96c-25.9 0-49.4 10.2-66.6 26.9l-94.1-47c.5-3.9 .7-7.8 .7-11.9s-.2-8-.7-11.9l94.1-47C302.6 213.8 326.1 224 352 224z"/></svg>
                        </div>
                    </div>
                    <div class="comment-content">
                        %s
                    </div>
                </div>
            </div>', $blinkCss, $args['id'],  $args['author']['image'], $args['author']['name'], $color, $icon, ucfirst($role), $args['author']['name'], $args['date']['ago'], $args['date']['full'], $replyID, generate_star_rating($args['rating']), $url, $title, $args['author']['image'], $message);
}

function get_comments_hiarchy_html_code($comments, $id=0){
    $output = '';
    
    if( ! empty( $comments ) ){
        foreach($comments as $key => $c){
            $output .= '<li class="hm_cmt_list">';
            $output .= get_comment_template($c, $id == 0 ? $c['id'] : $id);
            
            if( ! empty( $c['children'] ) ){
                $output .= '<ul class="comments-list reply-list">';
                $output .= get_comments_hiarchy_html_code($c['children'], $c['id']);
                $output .= '</ul>';
            }
            
            $output .= '</li>';
        }
    }
    
    return empty($output) ? "<div style='text-align:center;border-radius: 0.25rem;padding: 0.75rem 1.25rem;color: #721c24 !important;background-color: #f8d7da;border:1px solid #f5c6cb;'>Be a First to submit review!!!</div>" : $output;
}

function get_comment_single_template( $cmt, $blink=false ){
    $date = strtotime($cmt->date);    
    $user = get_user_by("id", $cmt->user);

    return array(
        'id' => $cmt->id,
        'blink' => $blink,
        'rating' => $cmt->review,
        "post" => $cmt->post,
        'message' => $cmt->message,
        'author' => array(
            'image' => get_avatar_url( $cmt->user ),
            'name' => @$user->name,
            'id' => @$user->id,
            'role' => @$user->role
        ),
        'date' => array(
            'full'  => date("M d, Y H:i A", strtotime($cmt->date)),
            'ago' => human_time_diff($date, time()) . " ago"
        ),
        'children' => array()
    );
}

function get_comments_hiarchy($args, $parent=0){

    global $db;

    if( isset( $args['postid'] ) && !empty( $args['postid'] ) ){
        $db->where("id", $args['postid']);
        unset($args['postid']);
    }else{
        $db->where("status", "active");
        $db->where("post", $args['id']);
        
        if( $parent > 0 ){
            $db->where("parent", "$parent");
        }else{
            $db->where("parent", "0");
        }
    }

    $db->orderBy($args['orderby'], $args['order']);
    $db->pageLimit = 5;
    $comments = $db->ObjectBuilder()->paginate("comments", $args['page']);
    
    $output = array();
    if( ! empty( $comments ) ){
        foreach($comments as $key => $cmt){
            $isBlink = @$args['firstcomment'] == $cmt->id;
            $temp = get_comment_single_template($cmt, $isBlink);
            $temp['children'] = get_comments_hiarchy($args, $cmt->id);
            $output[] = $temp;
        }
    }
    
    return $output;
}

function get_comment_overview( $postid ){
    global $db;
    $db->where("status", "active");
    $db->where("post", $postid);

    $results = $db->get("comments", null, array("review"));
    $output = array(
        "single" => array(
            "five" => 0,
            "four" => 0,
            "three" => 0,
            "two" => 0,
            "one" => 0
        ),
        "overview" => 0,
        "totalsum" => 0, 
        "total" => count($results),
        "per" => 0
    );

    if( ! empty( $results ) ){
        foreach($results as $res){
            $output["totalsum"] += $res->review;
    
            if( $res->review == 5 ){
                $output["single"]["five"]++;
            }else if( $res->review == 4 ){
                $output["single"]["four"]++;
            }else if( $res->review == 3 ){
                $output["single"]["three"]++;
            }else if( $res->review == 2 ){
                $output["single"]["two"]++;
            }else if( $res->review == 1 ){
                $output["single"]["one"]++;
            }
        }
    
        $output["overview"] = round(floatval($output["totalsum"]) / floatval($output['total']), 1);
        $output["per"] = round($output["overview"] / 5, 4) * 100; 
    }
    
    return $output;
}

function comment_id_already_exists($comments){
    foreach($comments as $cmt){
        if( filter_var($cmt['blink'], FILTER_VALIDATE_BOOLEAN) ){
            return true;
        }

        foreach($cmt['children'] as $c){
            if( filter_var($c['blink'], FILTER_VALIDATE_BOOLEAN) ){
                return true;
            }
        }
    }

    return false;
}

function get_comments_hiarchy_html($args){
    global $db;
    $comments = get_comments_hiarchy($args);
    
    if( 
        isset( $args['firstcomment'] ) 
        && !empty( $args['firstcomment'] ) 
        && $args['page'] == 1 
        && !comment_id_already_exists($comments)
    ){
        $db->where ("id", $args['firstcomment']);
        $firstComment = $db->getOne("comments");
        if( ! empty( $firstComment ) ){
            if( intval($firstComment->parent) > 0 ){
                $args['postid'] = $firstComment->parent;
                $firstCommentTemp = get_comments_hiarchy($args, 0);
            }else{
                $firstCommentTemp = array(get_comment_single_template($firstComment, true));
            }
            $comments = array_merge($firstCommentTemp, $comments);
        }
    }

    return get_comments_hiarchy_html_code($comments);
}

function process_quill_content($contents){
    $contents = str_replace('<pre class="ql-syntax" spellcheck="false">', '<pre class="highlight-code">', $contents);
    $contents = str_replace('\\', '\\\\', $contents);
    $contents = stripslashes($contents);
    return $contents;
}

add_action("ajax/req/submit_comment", "toolkitspro_submit_comment");
function toolkitspro_submit_comment(){
    $output = array(
        'success' => true,
        'message' => "Thanks for the message."
    );
    
    global $db;
    $postID = $_POST['postID'];
    $message = process_quill_content(stripslashes($_POST['message']));
    $parent = isset($_POST['parent']) ? (int) $_POST['parent'] : 0;
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    
    if( empty( $message ) || (int) $postID <= 0 ){
        $output = array(
            'success' => false,
            'message' => "All Field are required!!!"
        );
    }else{
        $commentArgs = array(
            "user" => get_current_id(),
            "post" => $postID,
            "message" => $message,
            "review" => $rating,
            "parent" => 0,
            "status" => "active",
            "date" => date("Y-m-d H:i:s")
        );
        if( $parent > 0 ){
            $commentArgs["parent"] = $parent;
        }
        $commentID = $db->insert("comments", $commentArgs);

        if( empty( $commentID ) ){
            $output = array(
                'success' => false,
                'message' => "Unable to submit message!!!"
            );
        }
    }
    
    ast_send_json($output);
}

add_action("ajax/req/get_comment", "toolkitspro_get_all_reviews");
add_action("ajax/req/nologin/get_comment", "toolkitspro_get_all_reviews");
function toolkitspro_get_all_reviews(){
    $output = array(
        "success" => true,
        "html" => "",
        "comments" => 0,
        "comments_text" => "0"
    );
    
    $id = $_POST['postID'];
    $order = $_POST['order'];
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $commentin = isset($_POST['postin']) ? intval($_POST['postin']) : 0;
    
    $total = get_comments_number($id);
    $output['comments'] = $total;
    $output['comments_text'] = tkp_format_number($total);
    
    $args = array(
        'orderby' => 'id',
        'order' => $order > 0 ? "ASC" : "DESC",
        'id' => $id,
        'page' => $page
    );
    
    if( $commentin ){
        $args['firstcomment'] = $commentin;
    }
    
    $output['html'] = get_comments_hiarchy_html($args);
    $parent_count = $page == 1 ? get_comment_count_parent($id) : 0;
    $output['parent_count'] = ceil($parent_count / 5);
    $output['comments_raw'] = get_comments_hiarchy($args);
    $output['reviews'] = get_comment_overview($id);
    
    ast_send_json($output);
}

add_action("tkp/update/setttings", "toolkitspro_update_comment_icon_with_colors");
function toolkitspro_update_comment_icon_with_colors($settingskey){
    if( $settingskey == 'colors' ){        
        if( isset( $_POST['settings']['dark']['primary'] ) ){
            $colors = $_POST['settings']['dark'];
            
            /** CHANGE LOGO COLOR */
            $commentstar = PLUGINS_PATH . "comment/assets/img/grey-star-dark-sample.svg";
            $outputFile = str_replace("grey-star-dark-sample.svg", "grey-star-dark.svg", $commentstar);
            $content = file_get_contents($commentstar);
            $content = str_replace('id="tool_primary_color"', sprintf('fill="%s"', $colors['primary']), $content);
            file_put_contents($outputFile, $content);
        }
    }
}