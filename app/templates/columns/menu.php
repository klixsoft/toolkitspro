<a href="<?php echo get_site_url(sprintf("admin/interface/menus/?id=footer_column_%s&title=%s", @strtolower($label), empty(@strtolower($label)) ? "Footer Column Menu" : "Footer Column " . @strtolower($label) . " Menu")) ?>" target="_blank" rel="noopener noreferrer">Click Here to edit</a>

<input type="text" name="menu" class="d-none" value="footer_column_<?php echo @strtolower($label); ?>">