<div class="main_tool_content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-boxs" id="tool_content_container">
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
                    do_action("ast/before/tool/descrition", $tooldata, "tool");
                ?>

                <div class="card-box p-4 mt-4">
                    <div class="form-group">
                        <h2 style="font-weight:bold;margin-bottom:15px;font-size:1.6rem;">About Tool</h2>

                        <div class="tool_content">
                            <?php echo $tooldata->description; ?>
                        </div>
                    </div>
                </div>

                <?php
                    /**
                     * After description for other section
                     * 
                     * @since 1.0
                     */
                    do_action("ast/after/tool/descrition", $tooldata, "tool");
                ?>
            </div>
        </div>
    </div>
</div>