
<div class="select-baths">
	
	<?php
	$selected_bath = isset( $_REQUEST['search_baths'] ) ? $_REQUEST['search_baths'] : '';
	?>
	<select class="baths-select" data-placeholder="<?php esc_attr_e( 'Filter by bath', 'cityo' ); ?>" name="search_baths">
		<option value=""><?php esc_attr_e( 'Filter by bath', 'cityo' ); ?></option>

		<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
			<option value="<?php echo esc_attr( $i ); ?>"<?php echo trim($i == $selected_bath ? 'selected="selected"' : ''); ?>>
				<?php echo esc_attr( $i ); ?>+
			</option>
		<?php endfor; ?>
		
	</select>
</div>