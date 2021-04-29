<?php
	$exterior_colors = cityo_get_field_options('job_exterior_color');

	if ( !empty($exterior_colors['options']) ) { 
?>
		<div class="select-exterior_colors">
			
			<?php
			$selected_exterior_color = isset( $_REQUEST['search_exterior_color'] ) ? $_REQUEST['search_exterior_color'] : '';
			?>
			
			<select class="exterior_colors-select" data-placeholder="<?php esc_attr_e( 'Filter by exterior colors', 'cityo' ); ?>" name="search_exterior_color">
				<option value=""><?php esc_attr_e( 'Filter by exterior colors', 'cityo' ); ?></option>
				<?php foreach ( $exterior_colors['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_exterior_color ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>