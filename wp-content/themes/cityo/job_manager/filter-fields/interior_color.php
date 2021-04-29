<?php
	$interior_colors = cityo_get_field_options('job_interior_color');

	if ( !empty($interior_colors['options']) ) { 
?>
		<div class="select-interior_colors">
			
			<?php
			$selected_interior_color = isset( $_REQUEST['search_interior_color'] ) ? $_REQUEST['search_interior_color'] : '';
			?>
			
			<select class="interior_colors-select" data-placeholder="<?php esc_attr_e( 'Filter by interior color', 'cityo' ); ?>" name="search_interior_color">
				<option value=""><?php esc_attr_e( 'Filter by interior color', 'cityo' ); ?></option>
				<?php foreach ( $interior_colors['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_interior_color ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>