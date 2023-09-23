<style>
.docs-buttons {
    padding: 1rem;
    text-align: center;
}

.image-cropping-tool_content .card-box .form-control {
    padding: .375rem .75rem !important;
}

.cropImageBtn_container {
    position: sticky;
    bottom: 0;
}

#cropImageBtn:hover,
#cropImageBtn:focus,
#cropImageBtn:active {
    background: var(--primary) !important;
    color: #fff !important;
}

.aspect_item .preview {
    border: 3px solid #000;
}

.aspect_ratio_calculator {
    display: inline-flex;
    justify-content: flex-start;
    align-items: end;
    flex-wrap: wrap;
    margin-top: 10px;
}

.aspect_ratio_calculator .aspect_item {
    cursor: pointer;
    text-align: center;
    margin-right: 20px;
    margin-bottom: 10px;
}

.aspect_ratio_calculator .aspect_item.active .preview {
    border-color: #009688;
}

.aspect_ratio_calculator .aspect_item.active .name {
    color: #009688;
}

#imagePreview canvas {
    width: 100%;
    height: 100%;
}

@media only screen and (max-width:990px) {
    .docs-buttons {
        padding: 1rem 0;
    }

    .docs-buttons .btn-group {
        margin-bottom: 10px;
    }
}
</style>

<div class="image-cropping-tool_content">
    <div class="row image_upload_area">
        <div class="col-12">
            <div class="card-box p-3">
                <div class="image-cropping-tool_submit_form">
                    <div class="form-group">
                        <?php
                            echo get_drag_and_drop_field(array(
                                "supports" => "Images (JPEG, JPG, PNG, WEBP)",
                                "icon" => "las la-image",
                                "accepts" => "image/*"
                            ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row image_edit_area" style="display:none;">
        <div class="col-md-8">
            <div class="card-box">
                <div class="col-md-12 docs-buttons">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1"
                            title="Zoom In">
                            <span class="docs-tooltip">
                                <span class="las la-search-plus"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1"
                            title="Zoom Out">
                            <span class="docs-tooltip">
                                <span class="las la-search-minus"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                            data-second-option="0" title="Move Left">
                            <span class="docs-tooltip">
                                <span class="las la-arrow-left"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="10"
                            data-second-option="0" title="Move Right">
                            <span class="docs-tooltip">
                                <span class="las la-arrow-right"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                            data-second-option="-10" title="Move Up">
                            <span class="docs-tooltip">
                                <span class="las la-arrow-up"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                            data-second-option="10" title="Move Down">
                            <span class="docs-tooltip">
                                <span class="las la-arrow-down"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45"
                            title="Rotate Left">
                            <span class="docs-tooltip">
                                <span class="las la-undo-alt"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45"
                            title="Rotate Right">
                            <span class="docs-tooltip">
                                <span class="las la-redo-alt"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                            title="Flip Horizontal">
                            <span class="docs-tooltip">
                                <span class="las la-arrows-alt-h"></span>
                            </span>
                        </button>

                        <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                            title="Flip Vertical">
                            <span class="docs-tooltip" data-toggle="tooltip" title=""
                                data-original-title="cropper.scaleY(-1)">
                                <span class="las la-arrows-alt-v"></span>
                            </span>
                        </button>
                    </div>
                </div>


                <div class="image_editor w-100 position-relative">
                    <img src="<?php echo get_site_url(); ?>tools/image-cropping-tool/crop.jpg" id="imageeditor"
                        class="w-100" />
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box">
                <div class="options p-3">
                    <div class="form-group">
                        <label class="fw-normal">Aspect Ratio</label>
                        <div class="aspect_ratio_calculator">
                            <div class="aspect_item active">
                                <div class="preview" data-ratio="free" style="width: 30px; height: 30px;"></div>
                                <div class="name">Free</div>
                            </div>

                            <?php
                                foreach(get_aspect_ratios() as $ratio){
                                    echo sprintf('<div class="aspect_item"><div class="preview" data-ratio="%s" style="width: %spx; height: %spx;"></div><div class="name">%s</div></div>', $ratio['ratio'], $ratio['width'], $ratio['height'], $ratio['ratio']);
                                }
                            ?>
                        </div>
                    </div>

                    <div class="form-group  mt-3">
                        <label class="fw-normal">Width (px)</label>
                        <input type="number" name="width" placeholder="0" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label class="fw-normal">Height (px)</label>
                        <input type="number" name="height" placeholder="0" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label class="fw-normal">Position X (px)</label>
                        <input type="number" name="posX" placeholder="0" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label class="fw-normal">Position Y (px)</label>
                        <input type="number" name="posY" placeholder="0" class="form-control">
                    </div>
                </div>

                <div class="button-row text-center w-100 cropImageBtn_container">
                    <button id="cropImageBtn" class="btn btn-primary w-100 rounded-0">Download Image</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imagePreview" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewLabel">Download Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary finalDownloadImage">Download Image</button>
            </div>
        </div>
    </div>
</div>