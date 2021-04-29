<?php
	$transmissions = cityo_get_field_options('job_transmission');

	if ( !empty($transmissions['options']) ) { 
?>
		<div class="select-transmissions">
			
			<?php
			$selected_transmission = isset( $_REQUEST['search_transmission'] ) ? $_REQUEST['search_transmission'] : '';
			?>
			
			<select class="transmissions-select" data-placeholder="<?php esc_attr_e( 'Filter by transmission', 'cityo' ); ?>" name="search_transmission">
				<option value=""><?php esc_attr_e( 'Filter by transmission', 'cityo' ); ?></option>
				<?php foreach ( $transmissions['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_transmission ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>