<div class="select-types">
	
	<?php

	$placeholder = !empty($types_label) ? $types_label : esc_html__( 'Filter by type', 'cityo' );

	

		$selected_type = '';
		//try to see if there is a search_categories (notice the plural form) GET param
		$search_types = isset( $_REQUEST['job_type_select'] ) ? $_REQUEST['job_type_select'] : '';
		
		if ( ! empty( $search_types ) && is_array( $search_types ) ) {
			$search_types = $search_types[0];
		}
		$search_types = sanitize_text_field( stripslashes( $search_types ) );
		if ( ! empty( $search_types ) ) {

			if ( is_numeric( $search_types ) ) {
				$selected_type = intval( $search_types );
			} else {
				$term = get_term_by( 'slug', $search_types, 'job_listing_type' );
				$selected_type = $term->term_id;
			}
		} elseif (  ! empty( $atts['job_types'] ) ) {
			if ( is_array($atts['job_types']) ) {
				$selected_type = $atts['job_types'][0];
			} else {
				$selected_type = $atts['job_types'];
			}
		}

		?>
		
		<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_type', 'hierarchical' => 1, 'show_option_all' => $placeholder, 'placeholder' => $placeholder, 'name' => 'job_type_select', 'orderby' => 'name', 'multiple' => false, 'hide_empty'  => false, 'selected' => $selected_type ) ); ?>

</div>