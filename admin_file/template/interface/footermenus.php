<style>
.footer_columns .card{
    min-height:305px;
    margin-bottom:1.5rem;
}

.footer_columns .card .card-header{
    background:rgba(0, 0, 0, 0.1);
}
</style>

<div class="col-md-12">
    <div class="card bg-white p-3">
        <div class="menu_sortabe">
            <div class="menu_title_container d-flex align-items-center justify-content-between">
                <h5 class="title" style="text-transform:uppercase;font-weight:bold;text-align:left;">Footer Columns</h5>
                <button type="button" class="btn btn-primary updateColumnsSettings btn-sm">Update Footer Columns</button>
            </div>
        </div>
    </div>

    <div class="footer_columns row px-2 mt-4">
        <?php
            $settings = (array) get_settings("footercolumns");
            $defaultSettings = array(
                "title" => "",
                "type" => "text",
                "text" => ""
            );
            $columnHelper = new \AST\Helper\ColumnHelper();
            foreach(array("one", "two", "three", "four", "five") as $col){
                $colsettings = isset($settings[$col]) && is_array($settings[$col]) && !empty( $settings[$col] ) ? $settings[$col] : array();
                $colsettings = array_merge($defaultSettings, $colsettings);
                $columnHelper->get_card($colsettings['type'], $col, $colsettings);
            }
        ?>
    </div>
</div>

<script>
const footercolumntemplate = <?php echo json_encode($columnHelper->get_card_json()); ?>;
</script>