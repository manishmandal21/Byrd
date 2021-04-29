<?php
	$min_max = cityo_get_min_max_meta_value('_job_lot_area');
	
	$min    = floor( $min_max->min );
	$max    = ceil( $min_max->max );
	$range_size = cityo_get_config('listing_filter_home_area_range', 100);

	if ( $min == $max ) {
		return;
	}

?>
	<div class="select-lot_area">
		
		<?php
		$selected_lot_area = isset( $_REQUEST['search_lot_area'] ) ? $_REQUEST['search_lot_area'] : '';
		?>
		<select class="lot_area-select" data-placeholder="<?php esc_attr_e( 'Filter by Lot area', 'cityo' ); ?>" name="search_lot_area">
			<option value=""><?php esc_attr_e( 'Filter by Lot area', 'cityo' ); ?></option>
			<?php for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) :
				$range_max = $range_min + $range_size;

				$opt_text = $range_min . ' - ' . $range_max;
				$opt_value = $range_min . '-' . $range_max;
			
			?>
				<option value="<?php echo esc_attr($opt_value); ?>" <?php echo trim($opt_value == $selected_lot_area ? 'selected="selected"' : ''); ?>><?php echo trim($opt_text); ?></option>

			<?php endfor; ?>
		</select>
	</div>