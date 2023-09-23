<style>
.faq_container .accordion .card {
	background: none;
	border: none;
}

.faq_container .accordion .card .card-header {
	background: none;
	border: none;
	padding: 0;
}

.faq_container .accordion .card-header h2 span {
	float: left;
	margin-top: 10px;
}

.faq_container .accordion .card-header .btn {
	font-size: 1.04rem;
	position: relative;
	font-weight: bold;
    width: 100%;
    text-align: left;
    color: rgba(0, 0, 0, 0.8);
    border:none;
    text-decoration: none;
    padding-left: 1.6rem;
}

.faq_container .accordion .card-header i {
	font-size: 1.2rem;
	font-weight: bold;
	position: absolute;
	left: 0;
	top: 13px;
}

.faq_container .accordion .card-body {
	color: #324353;
	padding: 0 .5rem;
}

.page-title::after {
	content: "";
	width: 80px;
	position: absolute;
	height: 3px;
	border-radius: 1px;
	background: #73bb2b;
	left: 0;
	bottom: -15px;
}
.faq_container .accordion .highlight .btn {
	color: #74bd30;
}
.faq_container .accordion .highlight i {
	transform: rotate(180deg);
}

.faq_container .accordion .btn-link.collapsed i:before{
    content: "\f13a";
}

.faq_container .accordion .card-header .btn:not(.collapsed){
    color:var(--primary);
}
</style>

<div class="main_tool_content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card-box py-3 px-4" id="tool_content_container">
                    <div class="has_messages"></div>

                    <?php
                        /**
                         * Render Tool Content 
                         * 
                         * @since 1.0
                         */
                        do_action("ast_tool_content_{$tooldata->extra}", $tooldata, $toolreport, $extraparams);
                        do_action("ast/tool/after/content", $tooldata, $toolreport, $extraparams);
                    ?>
                </div>

                <?php
                    /**
                     * Before description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/before/tool/descrition", $tooldata->id, "tool");
                ?>

                <div class="card-box mt-4 p-4">
                    <div class="form-group">
                        <h2 style="font-weight:bold;margin-bottom:15px;font-size:1.6rem;">About Tool</h2>

                        <div class="tool_content">
                            <?php
                                echo apply_filters("ast/post/description", $tooldata->description, $tooldata, $extraparams);
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                $faqQuestions = get_meta("tool", $tooldata->id, "faqQuestions", []);
                if( ! empty( $faqQuestions ) ):
                ?>
                <div class="card-box mt-4">
                    <div class="form-group">
                        <h2 class="px-4 pt-4 pb-0" style="font-weight:bold;margin-bottom:10px;font-size:1.6rem;">FAQ</h2>

                        <div class="faq_container px-4">
                            <div class="accordion pb-4" id="toolFaqQuestion">
                                <?php foreach($faqQuestions as $key => $faq): ?>
                                <div class="card">
                                    <div class="card-header" id="faqHeading<?php echo $key; ?>">
                                        <h2 class="clearfix mb-0">
                                            <a class="btn btn-link <?php echo $key == 0 ? '' : 'collapsed'; ?>" data-bs-toggle="collapse" data-bs-target="#faqContent<?php echo $key; ?>" aria-expanded="<?php echo $key == 0 ? 'true' : 'false'; ?>" aria-controls="faqContent<?php echo $key; ?>"><i class="las la-chevron-circle-up"></i> <?php echo @$faq['qn']; ?></a>
                                        </h2>
                                    </div>
                                    <div id="faqContent<?php echo $key; ?>" class="collapse <?php echo $key == 0 ? 'show' : ''; ?>" aria-labelledby="faqHeading<?php echo $key; ?>" data-parent="#toolFaqQuestion">
                                        <div class="card-body mb-3 mt-2 mx-2"><?php echo @$faq['ans']; ?></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                    /**
                     * After description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/after/tool/descrition", $tooldata, "tool");
                ?>
            </div>

            <div class="col-md-3">
                <div class="sidebar_content">
                    <?php
                        /**
                         * Render Tool Content 
                         * 
                         * @since 1.0
                         */
                        do_action("ast/post/sidebar", $tooldata, "tool");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>