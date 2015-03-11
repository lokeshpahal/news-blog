<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class google_ads_master_admin_shortcodes_table_un extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
?>
<form method="post" width='1'>
<fieldset class="options">

<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col" style="vertical-align:middle"><input type="checkbox"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="200"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Universal Shortcode', 'google_ads_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"><legend><h3><?php _e('&nbsp;[google-ads-master-un]', 'google_ads_master'); ?></h3></legend></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" scope="col"></th>
			<th class="manage-column column-columnname" scope="col" width="200"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<p>Check Add-ons Page.</p>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname"></td>
		</tr>
	</tbody>
</table>
<p class="submit"><input class='button-primary' type='submit' name='update' value='<?php _e("Save Shortcode UN", 'google_ads_master'); ?>' id='submitbutton' /></p>
</fieldset>
</form>
<?php
	}
//CLASS ENDS
}