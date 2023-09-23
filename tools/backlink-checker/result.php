<style>
.result_icon {
    background: var(--primary);
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    border-radius: 100%;
    color: #fff;
}

.ancher_text {
    text-decoration: none;
    color: #000;
}

.ancher_text:hover span.text {
    color: var(--primary);
}

.ancher_text .link {
    text-decoration: underline;
}

.backlink_content_wrapper table tr td:nth-child(1),
.backlink_content_wrapper table tr th:nth-child(1) {
    width: 7%;
    text-align:center;
}

.backlink_content_wrapper table tr td:nth-child(2),
.backlink_content_wrapper table tr th:nth-child(2) {
    width: 48%;
}

.backlink_content_wrapper table tr td:nth-child(3),
.backlink_content_wrapper table tr th:nth-child(3) {
    width: 45%;
}
</style>

<div class="backlink_content_wrapper">
    <div class="row">
        <div class="col pe-0">
            <div class="p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-globe"></i>
                </div>
                <div>
                    <div class="fw-bold">Domain Authority</div>
                    <div class="checkurl"><?php echo @$mozAPI->domainAuthority; ?></div>
                </div>
            </div>
        </div>
        <div class="col px-0">
            <div class="p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-link"></i>
                </div>
                <div>
                    <div class="fw-bold">Backlinks</div>
                    <div class="domainip"><?php echo @$mozAPI->totalBacklinks; ?></div>
                </div>
            </div>
        </div>
        <div class="col ps-0">
            <div class="p-4 border">
                <div class="result_icon me-2 float-start">
                    <i class="las la-link"></i>
                </div>
                <div>
                    <div class="fw-bold">Linking Websites</div>
                    <div class="country"><?php echo @$mozAPI->linkingWebsite; ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php if( ! empty( @$mozAPI->links ) ): ?>

    <div class="p-3 border mt-3 bg-light">
        <p class="mb-0">This report is limited to the top 50 backlinks pointing at your domain.</p>
    </div>

    <div class="table-responsive w-100">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>DA</th>
                    <th>Refering Page</th>
                    <th>Ancher & Target URL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($mozAPI->links as $link):
                ?>
                <tr>
                    <td><?php echo $link->source->da; ?></td>
                    <td>
                        <a rel="nofollow noindex" target="_blank" href="<?php echo $link->source->link; ?>"
                            class="ancher_text">
                            <span class="d-block text line-2"><?php echo $link->source->text; ?></span>
                            <span class="d-block link text-muted mt-1"><?php echo $link->source->link; ?></span>
                        </a>
                    </td>

                    <td>
                        <a rel="nofollow noindex" target="_blank" href="<?php echo $link->target->link; ?>"
                            class="ancher_text">
                            <span class="d-block text line-2"><?php echo $link->target->text; ?></span>
                            <span class="d-block link text-muted mt-1"><?php echo $link->target->link; ?></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="p-3 border bg-light">
        <p class="mb-0">This report is limited to the top 50 backlinks pointing at your domain.</p>
    </div>
    <?php endif; ?>
</div>