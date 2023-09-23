<div class="col-md-4">
    <div class="card bg-white p-3">
        <div class="add_menu_item_form">
            <h5 class="title mb-3" style="text-transform:uppercase;font-weight:bold;text-align:center;">Add Menu Item</h5>

            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" required name="title">
            </div>

            <div class="form-group">
                <label>Link</label>
                <input type="text" class="form-control" required name="link">
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-primary addNewMenuItem w-100">Add Menu Item</button>
            </div>
        </div>
    </div>
</div>

<style>
ol.sortable,
ol.sortable ol {
    list-style-type: none;
}

.sortable li div.menuEdit,
.sortable li div.menuDiv {
    border: 1px solid #d4d4d4;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    cursor: move;
    border-color: #D4D4D4 #D4D4D4 #BCBCBC;
    margin: 0;
    padding: 5px 10px;
}

li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
    border-color: #999;
}

.disclose,
.expandEditor {
    cursor: pointer;
    width: 20px;
    display: none;
}

.sortable li.mjs-nestedSortable-collapsed>ol {
    display: none;
}

.sortable li.mjs-nestedSortable-branch>div>.disclose {
    display: inline-block;
}

.sortable span.ui-icon {
    display: inline-block;
    margin: 0;
    padding: 0;
}

.menuDiv {
    background: #EBEBEB;
}

.menuEdit {
    background: #FFF;
}

.itemTitle {
    vertical-align: middle;
    cursor: pointer;
}

.deleteMenu {
    float: right;
    cursor: pointer;
}

.placeholder {
    outline: 1px dashed #4183C4;
    margin-bottom: 1rem;
}

li.mjs-nestedSortable-branch.mjs-nestedSortable-expanded>div,
li.mjs-nestedSortable-expanded .menuDiv,
.mjs-nestedSortable-leaf,
.mjs-nestedSortable-collapsed {
    margin-bottom: 10px;
}
</style>

<?php
$menuID = isset($_GET['id']) && !empty($_GET['id']) ? trim($_GET['id']) : "menus";
$menuTitle = isset($_GET['title']) && !empty($_GET['title']) ? trim($_GET['title']) : "Menus";
$menusSettings = get_settings($menuID);
if( empty( $menusSettings ) ){
    $menusSettings = (object) array(
        "menuitem_1" => array(
            "title" => "No Menu Found",
            "link" => "#"
        )
    );
}
$menusSettings = (array) $menusSettings;
$count = 1;
?>

<div class="col-md-8">
    <div class="card bg-white p-3">
        <div class="menu_sortabe">
            <div class="menu_title_container d-flex align-items-center justify-content-between mb-3">
                <h5 class="title" style="text-transform:uppercase;font-weight:bold;text-align:left;"><?php echo $menuTitle; ?></h5>
                <button data-save="<?php echo $menuID; ?>" type="button" class="btn btn-primary updateMenuSettings btn-sm">Update Menu</button>
            </div>

            <div class="menus_sort_container">
                <ol class="m-0 p-0 sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">

                    <?php
                        render_menu_template($menusSettings, $count); 
                    ?>
                </ol>
            </div>
        </div>
    </div>
</div>