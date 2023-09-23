<div class="col-12">
    <div class="card bg-white p-3">
        <table class="table">
            <tbody>
                <tr>
                    <td style="width: 300px;">Sitemap URL <br><small>(Use the link to submit sitemap into search
                            engines)</small></td>
                    <td><?php echo get_site_url("sitemap.xml"); ?></td>
                </tr>
                <tr>
                    <td style="width: 300px;">Sitemap File</td>
                    <td style="color: green; font-weight: bold;"> File Found <br>
                        <a target="_blank" href="<?php echo get_site_url("sitemap.xml"); ?>"
                            class="btn btn-success btn-sm" title="View Sitemap"><i class="fa fa-link"
                                aria-hidden="true"></i> View Sitemap File</a>
                    </td>
                </tr>
                <tr>
                    <td>Build your sitemap</td>
                    <td>
                        <button type="button" class="buildAdminSitemap btn btn-primary btn-sm" title="Build Sitemap"><i
                                class="fa fa-sitemap" aria-hidden="true"></i> Rebuild Sitemap</button>
                    </td>
                </tr>

                <tr>
                    <td>Configure Sitemap Settings</td>
                    <td><a type="button" class="btn btn-warning btn-sm"
                            href="<?php echo get_site_url("admin/setting/sitemap/"); ?>"><i class="fa fa-sitemap"
                                aria-hidden="true"></i> Configure</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>