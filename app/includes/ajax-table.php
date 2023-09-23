<?php
use AST\Users;

add_action("ajax/req/ast_get_all_users", "ast_get_all_users_admin");
function ast_get_all_users_admin(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? $startfrom / $perpage : 1;
    $db->pageLimit = $perpage;

    $columns = array("sn", "email", "role", "role", "action");

    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $users = $db->arraybuilder()->paginate("users", $page);

    $data = array();

    $currentuserid = get_current_id();
    foreach($users as $key => $pppp){

        //username
        $username = $pppp['email'] . "(" . $pppp['username'] . ")";
        
        $actions = '';
        if($currentuserid != $pppp['id']){
            $adminediturl = get_site_url( sprintf("admin/user/edit/%s/", $pppp['id']) );
            $actions .= sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-edit"></i></a>', $adminediturl);
            $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="users" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);

            $usernameactions = sprintf('<a href="javascript:void(0);" data-id="%d" class="send_user_reset_password_link">Pasword Reset Link</a> | ', $pppp['id']);

            if( strtolower($pppp['status']) == 'pending' ){
                $usernameactions .= sprintf('<a href="javascript:void(0);" data-id="%d" class="send_user_email_activation_link">Email Activation Link</a> | ', $pppp['id']);
            }
            $username .= sprintf('<div class="user_name_actions">%s</div>', rtrim(trim($usernameactions), "|"));
        }else{
            $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-edit"></i></a>', get_site_url("admin/user/profile/"));
        }

        $role = 'secondary';
        if( $pppp['role']  == 'administrator' ){
            $role = "success";
        }
        $role = sprintf('<span class="badge badge-%s">%s</span>', $role, ucfirst($pppp['role']));

        $status = 'success';
        if( $pppp['status']  == 'rejected' ){
            $status = "danger";
        }else if( $pppp['status']  == 'pending' ){
            $status = "warning";
        }
        $status = sprintf('<span class="badge badge-%s">%s</span>', $status, ucfirst($pppp['status']));

        $data[] = array(
            $key + 1,
            $username,
            $role,
            $status,
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	count($users),
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_posts_admin", "allsmarttools_get_all_posts_admin");
function allsmarttools_get_all_posts_admin(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? $startfrom / $perpage : 1;
    $db->pageLimit = $perpage;

    $columns = array("title", "author", "status", "date", "modified");

    $db->where("type", "post");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("posts", $page);

    $data = array();
    foreach($products as $post){

        $viewlink = get_post_url("slug", $post['slug']);
        $adminediturl = get_site_url(sprintf("admin/post/edit/%s/", $post['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-edit"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="posts" data-id="%s"><i class="las la-trash"></i></button>', $post['id']);
        $actions .= sprintf('<a class="btn btn-warning viewpost" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $viewlink);

        $fullname = "Unknown";
        $author = new Users($post['author']);
        $author = $author->get();
        if( $author ){
            $fullname = $author->name;
        }

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $viewlink, $post['title']);
        $data[] = array(
            $title,
            $fullname,
            get_post_status_html($post['status']),
            $post['date'],
            $post['modified'],
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	count($products),
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_pages_admin", "ast_get_all_pages_admin");
function ast_get_all_pages_admin(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? $startfrom / $perpage : 1;
    $db->pageLimit = $perpage;

    $columns = array("title", "author", "status", "date", "modified");

    $db->where("type", "page");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("posts", $page);

    $data = array();
    foreach($products as $pppp){

        $viewlink = get_page_url("slug", $pppp['slug']);
        $adminediturl = get_site_url(sprintf("admin/page/edit/%s/", $pppp['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-edit"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="posts" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);
        $actions .= sprintf('<a class="btn btn-warning viewpost" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $viewlink);

        $fullname = "Unknown";
        $author = new Users($pppp['author']);
        $author = $author->get();
        if( $author ){
            $fullname = $author->name;
        }

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $viewlink, $pppp['title']);
        $data[] = array(
            $title,
            $fullname,
            get_post_status_html($pppp['status']),
            $pppp['date'],
            $pppp['modified'],
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	count($products),
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_plans_admin", "ast_get_all_plans_admin");
function ast_get_all_plans_admin(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? $startfrom / $perpage : 1;
    $db->pageLimit = $perpage;

    $columns = array("title", "author", "status", "date", "modified");

    $db->where("type", "plan");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("posts", $page);

    $data = array();
    foreach($products as $pppp){

        $adminediturl = get_site_url(sprintf("admin/plan/edit/%s/", $pppp['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-edit"></i></a>', $adminediturl);
        
        if( $pppp['extra'] == 'plan' ){
            $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="posts" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);
        }

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $adminediturl, $pppp['title']);
        $data[] = array(
            $title,
            get_meta("plan", $pppp['id'], "monthlyprice", "0"),
            get_meta("plan", $pppp['id'], "yearlyprice", "0"),
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	count($products),
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_posts_category", "allsmarttools_get_all_posts_category");
function allsmarttools_get_all_posts_category(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";


    $db->where("cat_of", "post");
    if( ! empty( $searchValue ) ){
        $db->where("`title` LIKE ? ", array("%$searchValue%"));
    }

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? ($startfrom / $perpage) + 1 : 1;
    $db->pageLimit = $perpage;

    $columns = array("title", "count");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("category", $page);

    $totalCount = intval($db->totalCount);
    $data = array();
    foreach($products as $pppp){

        $viewlink = get_blog_category_url("slug", $pppp['slug']);
        $adminediturl = get_site_url(sprintf("admin/post/category/edit/%s/", $pppp['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editcategory"><i class="las la-edit"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="category" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);
        $actions .= sprintf('<a class="btn btn-warning viewpost" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $viewlink);

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $viewlink, $pppp['title']);
        $data[] = array(
            $title,
            get_posts_count_by_category($pppp['id']),
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	$totalCount,
        "recordsFiltered"	=>	$totalCount,
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_tools_category", "ast_get_all_tools_category");
function ast_get_all_tools_category(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : -1;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";


    $db->where("cat_of", "tool");
    if( ! empty( $searchValue ) ){
        $db->where("`title` LIKE ? ", array("%$searchValue%"));
    }

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? ($startfrom / $perpage) + 1 : 1;
    $db->pageLimit = $perpage;

    $columns = array("title", "count");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("category", $page);

    $totalCount = intval($db->totalCount);
    foreach($products as $pppp){

        $viewlink = get_tool_category_url( "slug", $pppp['slug'] );
        $adminediturl = get_site_url(sprintf("admin/tool/category/edit/%s/", $pppp['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editcategory"><i class="las la-edit"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="category" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);
        $actions .= sprintf('<a class="btn btn-warning viewpost" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $viewlink);

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $viewlink, $pppp['title']);
        $data[] = array(
            $title,
            get_tools_count_by_category($pppp['id']),
            $actions
        );
    }

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	$totalCount,
        "recordsFiltered"	=>	$totalCount,
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_tools", "ast_get_all_tools");
function ast_get_all_tools(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "desc";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";
    if( ! empty( $searchValue ) ){
        $db->where("(`title` LIKE ? OR `description` LIKE ?) ", array("%$searchValue%", "%$searchValue%"));
    }

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? ($startfrom / $perpage) + 1 : 1;
    $db->pageLimit = $perpage;

    $db->where("type", "tool");
    $columns = array("id", "title", "status", "views");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("posts", $page);

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	intval($db->totalCount),
        "data"		=>	[]
    );

    $data = array();
    foreach($products as $toolindex => $pppp){

        $viewlink = get_tool_url("slug", $pppp['slug']);
        $adminediturl = get_site_url(sprintf("admin/tool/edit/%s/", $pppp['id']));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-cog"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="posts" data-id="%s"><i class="las la-trash"></i></button>', $pppp['id']);
        $actions .= sprintf('<a class="btn btn-warning viewpost" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $viewlink);

        $sort = get_meta("tool", $pppp['id'], "sort", 0);

        $title = sprintf('<a href="%s" target="_blank">%s</a>', $viewlink, $pppp['title']);
        $data[] = array(
            "AST" . ($toolindex + (($page - 1) * $perpage) + 1),
            $title,
            get_post_status_html($pppp['status']),
            $pppp['views'],
            $sort,
            $actions
        );
    }
    
    $output['data'] = $data;
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_comments_admin", "toolkitspro_ast_get_all_comments_admin");
function toolkitspro_ast_get_all_comments_admin(){
    global $db;

    $columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    $columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "desc";

    $searchValue = isset( $_POST['search']['value'] ) ? trim($_POST['search']['value']) : "";
    if( ! empty( $searchValue ) ){
        $db->where("(`message` LIKE ?) ", array("%$searchValue%"));
    }

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? ($startfrom / $perpage) + 1 : 1;
    $db->pageLimit = $perpage;
    
    $columns = array("user", "message", "post", "date");
    if( $columnIndex >= 0 ){
        $db->orderBy($columns[$columnIndex], $columnSortOrder);
    }
    $products = $db->arraybuilder()->paginate("comments", $page);

    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	intval($db->totalCount),
        "data"		=>	[]
    );

    $data = array();
    foreach($products as $toolindex => $pppp){

        $user = get_user($pppp['user']);
        $post = get_post_by("id", $pppp['post']);

        if( $user && $post ){
            $userHTML = sprintf('<a href="%s" target="_blank">
                <span class="name">%s</span>
                <span class="link">%s</span>
            </a>', get_admin_url("user/edit/$user->id/"), $user->name, $user->email);

            $postURL = get_unknown_post_url($post->id);
            $postHTML = sprintf('<a href="%s" target="_blank">
                <span class="name">%s</span>
                <span class="link">View Post</span>
            </a>', $postURL, $post->title);

            $actions = sprintf('<div class="table_actions"><button data-id="%d" class="btn btn-success editcomments"><i class="las la-cog"></i></button>', $pppp['id']);
            $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="comments" data-id="%d"><i class="las la-trash"></i></button>', $pppp['id']);
            $actions .= sprintf('<a class="btn btn-warning viewcomments" href="%s" target="_blank"><i class="las la-eye"></i></a></div>', $postURL . "#comment_" . $pppp['id']);

            $data[] = array(
                $userHTML,
                sprintf('<div class="line-5 comment-response">%s</div>', $pppp['message']),
                $postHTML,
                $pppp['date'],
                $actions
            );
        }
    }
    
    $output['data'] = $data;
    echo json_encode($output);
    die();
}

add_action("ajax/req/ast_get_all_apikeys_admin", "ast_get_all_apikeys_admin");
function ast_get_all_apikeys_admin(){
    global $db;

    $startfrom = intval($_POST['start']);
    $perpage = intval($_POST['length']);

    $page = $startfrom > 0 ? ($startfrom / $perpage) + 1 : 1;
    $db->pageLimit = $perpage;

    $db->orderBy("id", "desc");
    $apikeys = $db->objectBuilder()->paginate("apikeys", $page);

    $data = array();
    foreach($apikeys as $toolindex => $apikey){
        
        $adminediturl = get_site_url(sprintf("admin/api-requests/edit/%s/", $apikey->id));
        $actions = sprintf('<div class="table_actions"><a href="%s" class="btn btn-success editpost"><i class="las la-cog"></i></a>', $adminediturl);
        $actions .= sprintf('<button class="btn btn-danger deletedatafromdb" data-from="posts" data-id="%s"><i class="las la-trash"></i></button>', $apikey->id);

        $data[] = array(
            $apikey->user,
            $apikey->apikey,
            $apikey->access_limit,
            $apikey->expiry,
            $actions
        );
    }
    
    $output = array(
        "draw"		=>	intval($_POST["draw"]),
        "recordsTotal"	=>	intval($db->totalCount),
        "recordsFiltered"	=>	intval($db->totalCount),
        "data"		=>	$data
    );
    echo json_encode($output);
    die();
}