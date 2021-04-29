<div class="select-garages">
	
	<?php
	$selected_garages = isset( $_REQUEST['search_garages'] ) ? $_REQUEST['search_garages'] : '';
	?>
	<select class="garages-select" data-placeholder="<?php esc_attr_e( 'Filter by garages', 'cityo' ); ?>" name="search_garages">
		<option value=""><?php esc_attr_e( 'Filter by garages', 'cityo' ); ?></option>

		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<option value="<?php echo esc_attr( $i ); ?>"<?php echo trim($i == $selected_garages ? 'selected="selected"' : ''); ?>>
				<?php echo esc_attr( $i ); ?>+
			</option>
		<?php endfor; ?>
		
	</select>
</div>