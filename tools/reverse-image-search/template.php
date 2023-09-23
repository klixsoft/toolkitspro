<style>
.imgsearch_card{
    background-color: #f4f4f4;
    margin-bottom: 20px;
    border-radius: 6px;
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 10px 10px 15px 10px;
}

.imgsearch_card a.btn{
    padding: 5px 10px;
    border-radius: 2px;
}
</style>

<div class="reverse-image-search_content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-boxs">
                <form class="remove_pdf_pages_submit_form">
                    <div class="form-group">
                        <?php
                            echo get_drag_and_drop_field(array(
                                "supports" => "PNG, JPG, WEBP or GIF",
                                "icon" => "las la-file-image",
                                "accepts" => "image/png,image/jpg,image/jpeg,image/gif,image/webp"
                            ));
                        ?>
                    </div>

                    <div class="form-group mt-4 d-none">
                        <label class="fw-bold h5">Result</label>

                        <div class="reverse_image_search_result mt-3">
                            <div class="row"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>