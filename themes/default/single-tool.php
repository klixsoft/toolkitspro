<?php
global $query;

/**
 * Render Beadcrum
 * 
 * @since 1.0
 */
$renderBeadcrum = apply_filters( "ast/tool/render/beadcrum", true, $tooldata, $extraparams );
if( $renderBeadcrum ){
    do_action("ast/tool/html/beadcrum", $tooldata, $extraparams);
}


/**
 * Main Content
 * 
 * @since 1.0
 */
$includeSidebar = apply_filters( "ast/tool/render/sidebar", true, $tooldata, $toolreport, $extraparams );
do_action( "ast/tool/html/content", $tooldata, $toolreport, $extraparams, $includeSidebar );
?>