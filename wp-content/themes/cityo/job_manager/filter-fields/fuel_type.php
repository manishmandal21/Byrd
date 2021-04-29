<?php
	$fuel_types = cityo_get_field_options('job_fuel_type');

	if ( !empty($fuel_types['options']) ) { 
?>
		<div class="select-fuel_types">
			
			<?php
			$selected_fuel_type = isset( $_REQUEST['search_fuel_type'] ) ? $_REQUEST['search_fuel_type'] : '';
			?>
			
			<select class="fuel_types-select" data-placeholder="<?php esc_attr_e( 'Filter by fuel type', 'cityo' ); ?>" name="search_fuel_type">
				<option value=""><?php esc_attr_e( 'Filter by fuel type', 'cityo' ); ?></option>
				<?php foreach ( $fuel_types['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_fuel_type ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>