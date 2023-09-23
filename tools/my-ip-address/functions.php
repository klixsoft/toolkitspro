<?php

add_action("ast_tool_content_my-ip-address", "ast_render_my_api_tool_content", 10, 2);
function ast_render_my_api_tool_content($tool, $report){

    $ipAddress = new \AST\Helper\IpApi();
    $result = $ipAddress->parse();
    
    if( isset( $result['content']['country'] ) ){
        $response = (object) $result['content'];
        require_once TOOLS_PATH . "my-ip-address/template.php";
    }else{
        echo '<div class="col-md-12">
            <div class="has_messages">
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <li>Unable to check your IP Address. Please refresh the page and try again!!!</li>
                    </ul>
                </div>
            </div>
        </div>';
    }
}