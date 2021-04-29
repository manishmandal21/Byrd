<div class="select-beds">
	
	<?php
	$selected_bed = isset( $_REQUEST['search_beds'] ) ? $_REQUEST['search_beds'] : '';
	?>
	<select class="beds-select" data-placeholder="<?php esc_attr_e( 'Filter by bed', 'cityo' ); ?>" name="search_beds">
		<option value=""><?php esc_attr_e( 'Filter by bed', 'cityo' ); ?></option>

		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<option value="<?php echo esc_attr( $i ); ?>"<?php echo trim($i == $selected_bed ? 'selected="selected"' : ''); ?>>
				<?php echo esc_attr( $i ); ?>+
			</option>
		<?php endfor; ?>
		
	</select>
</div>