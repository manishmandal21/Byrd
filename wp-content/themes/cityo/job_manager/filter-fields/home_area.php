<?php
	$min_max = cityo_get_min_max_meta_value('_job_home_area');
	
	$min    = floor( $min_max->min );
	$max    = ceil( $min_max->max );
	$range_size = cityo_get_config('listing_filter_home_area_range', 100);

	if ( $min == $max ) {
		return;
	}

?>
	<div class="select-home_area">
		
		<?php
		$selected_home_area = isset( $_REQUEST['search_home_area'] ) ? $_REQUEST['search_home_area'] : '';
		?>
		<select class="home_area-select" data-placeholder="<?php esc_attr_e( 'Filter by home area', 'cityo' ); ?>" name="search_home_area">
			<option value=""><?php esc_attr_e( 'Filter by home area', 'cityo' ); ?></option>
			<?php for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) :
				$range_max = $range_min + $range_size;

				$opt_text = $range_min . ' - ' . $range_max;
				$opt_value = $range_min . '-' . $range_max;
			
			?>
				<option value="<?php echo esc_attr($opt_value); ?>" <?php echo trim($opt_value == $selected_home_area ? 'selected="selected"' : ''); ?>><?php echo trim($opt_text); ?></option>

			<?php endfor; ?>
		</select>
	</div>