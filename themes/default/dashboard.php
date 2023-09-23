<section class="hero_section">
    <div class="container">
        <div class="main_content">
            <h1>Get ahead of your competition</h1>
            <h2>Powerful next-generation Search Engine Optimization i.e seo tools at your fingertips.</h2>

            <form class="search-box website_analysis_report mt-lg-5" action="<?php echo get_site_url(); ?>"
                method="post">
                <label id="analyzeWebsiteLabel" for="analyzeWebsiteInput" class="d-none">Enter Website URL</label>
                <input name="url" aria-labelledby="analyzeWebsiteLabel" id="analyzeWebsiteInput" autocomplete="off"
                    type="url" class="form-control" placeholder="Website URL" required>
                <button type="submit" class="btn btn-primary">Analyze</button>
            </form>
        </div>

        <!-- <div class="popular_tools_front mt-5">
            <div class="row">
                <?php
                    // $db->where("type", "tool");
                    // $db->orderby("views", "desc");
                    // $tools = $db->objectBuilder()->get("posts", 16);
                    // foreach($tools as $key => $tool){
                    //     $class = "";
                    //     if( $key >= 6 ){
                    //         $class = "only_show_6";
                    //     }
                    //     echo sprintf('<div class="col-sm-6 col-md-3 col-12 %s"><a href="%s" class="popular_tools">%s<a></div>', $class, get_tool_url("slug", $tool->slug), $tool->title);
                    // }
                ?>
            </div>
        </div> -->
    </div>
</section>

<section class="tools_section my-5">
    <div class="container">
        <div class="col-md-12">
            <?php
                $db->where("cat_of", "tool");
                $results = $db->get("category");
                foreach($results as $cat):
                    $categoryURL = get_site_url("tool/category/" . $cat->slug . "/");
                    $tools = get_tools_by_category($cat->id, 13, "views", "desc");
                    if( ! empty( $tools ) ):
            ?>
            <div class="category mb-3">
                <div class="title">
                    <div class="d-flex align-items-center">
                        <a class="text-decoration-none text-dark d-block" href="<?php echo $categoryURL; ?>"><h2><?php echo $cat->title; ?></h2></a>
                    </div>
                    <p><?php echo $cat->description; ?></p>
                </div>
                <div class="card-body pb-0">
                    <div class="tools">
                        <?php
                            $totalTools = get_tools_count_by_category($cat->id);
                            if( !empty( $tools ) ){
                                foreach($tools as $k => $tool){
                                    echo get_tool_card_html($tool);
                                }
                            }

                            if( $totalTools > count($tools) ){
                                echo sprintf('<a class="tool moretools_card" href="%s">
                                        <div class="tool_card">
                                            <div>
                                                <span class="count">%s+</span>
                                                <span class="text">More Tools</span>
                                            </div>
                                        </div>
                                    </a>', $categoryURL, $totalTools - count($tools));
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>