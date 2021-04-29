<div class="select-rooms">
	
	<?php
	$selected_room = isset( $_REQUEST['search_rooms'] ) ? $_REQUEST['search_rooms'] : '';
	?>
	<select class="rooms-select" data-placeholder="<?php esc_attr_e( 'Filter by room', 'cityo' ); ?>" name="search_rooms">
		<option value=""><?php esc_html_e( 'Rooms: any', 'cityo' ); ?></option>

		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<option value="<?php echo esc_attr( $i ); ?>"<?php echo trim($i == $selected_room ? 'selected="selected"' : ''); ?>>
				<?php echo esc_attr( $i ); ?>+
			</option>
		<?php endfor; ?>
		
	</select>
	
</div>