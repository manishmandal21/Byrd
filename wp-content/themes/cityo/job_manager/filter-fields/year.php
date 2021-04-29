<?php
	$years = cityo_get_field_options('job_year');

	if ( !empty($years['options']) ) { 
?>
		<div class="select-years">
			
			<?php
			$selected_year = isset( $_REQUEST['search_year'] ) ? $_REQUEST['search_year'] : '';
			?>
			
			<select class="years-select" data-placeholder="<?php esc_attr_e( 'Filter by year', 'cityo' ); ?>" name="search_year">
				<option value=""><?php esc_html_e( 'All years', 'cityo' ); ?></option>
				<?php foreach ( $years['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_year ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>