<?php
	$contracts = cityo_get_field_options('job_contract');
	$selected_contract = isset( $_REQUEST['search_contract'] ) ? $_REQUEST['search_contract'] : '';
	if ( !empty($contracts['options']) ) { 
?>
	<div class="select-contracts">
		
		<select class="contracts-select" data-placeholder="<?php esc_attr_e( 'Filter by contract', 'cityo' ); ?>" name="search_contract">
			<option value=""><?php esc_attr_e( 'Filter by contract', 'cityo' ); ?></option>
			<?php foreach ( $contracts['options'] as $key => $title ) : ?>
				<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_contract ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
			<?php endforeach; ?>
		</select>
		
	</div>
<?php } ?>