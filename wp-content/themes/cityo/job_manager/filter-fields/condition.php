<?php
	$conditions = cityo_get_field_options('job_condition');

	if ( !empty($conditions['options']) ) { 
?>
		<div class="select-conditions">
			
			<?php
			$selected_condition = isset( $_REQUEST['search_condition'] ) ? $_REQUEST['search_condition'] : '';
			?>
			
			<select class="conditions-select" data-placeholder="<?php esc_attr_e( 'Filter by condition', 'cityo' ); ?>" name="search_condition">
				<option value=""><?php esc_attr_e( 'Filter by condition', 'cityo' ); ?></option>
				<?php foreach ( $conditions['options'] as $key => $title ) :
					if ( $key !== '' ) {
				?>
					<option value="<?php echo esc_attr($key); ?>" <?php echo trim($key == $selected_condition ? 'selected="selected"' : ''); ?>><?php echo trim($title); ?></option>
				<?php } ?>
				<?php endforeach; ?>
			</select>
			
		</div>
<?php } ?>