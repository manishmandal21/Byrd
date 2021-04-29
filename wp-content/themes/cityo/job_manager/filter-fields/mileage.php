<?php
	$min_max = cityo_get_min_max_meta_value('_job_mileage');
	
	$min    = floor( $min_max->min );
	$max    = ceil( $min_max->max );
	$range_size = 1000;

	if ( $min == $max ) {
		return;
	}

?>
	<div class="select-mileage">
		
		<?php
		$selected_mileage = isset( $_REQUEST['search_mileage'] ) ? $_REQUEST['search_mileage'] : '';
		?>
		
		<select class="mileage-select" data-placeholder="<?php esc_attr_e( 'Filter by mileage', 'cityo' ); ?>" name="search_mileage">
			<option value=""><?php esc_attr_e( 'Filter by mileage', 'cityo' ); ?></option>
			<?php for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) :
				$range_max = $range_min + $range_size;

				$opt_text = $range_min . ' - ' . $range_max.' '.cityo_get_config('listing_distance_unit', 'ft');
				$opt_value = $range_min . '-' . $range_max;
			
			?>
				<option value="<?php echo esc_attr($opt_value); ?>" <?php echo trim($opt_value == $selected_mileage ? 'selected="selected"' : ''); ?>><?php echo trim($opt_text); ?></option>

			<?php endfor; ?>
		</select>
		
	</div>