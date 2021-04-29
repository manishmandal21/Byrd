<?php

$first_regions = get_terms('job_listing_region', array(
    'orderby' => 'count',
    'hide_empty' => 0,
    'parent' => 0,
));

if ( !empty( $first_regions ) && !is_wp_error( $first_regions ) ) {

	$selected_region = '';
	//try to see if there is a search_categories (notice the plural form) GET param
	$search_regions = isset( $_REQUEST['job_region_select'] ) ? $_REQUEST['job_region_select'] : '';

	if ( ! empty( $search_regions ) && is_array( $search_regions ) ) {
		$search_regions = $search_regions[0];
	}
	$search_regions = sanitize_text_field( stripslashes( $search_regions ) );
	if ( ! empty( $search_regions ) ) {
		if ( is_numeric( $search_regions ) ) {
			$selected_region = intval( $search_regions );
		} else {
			$term = get_term_by( 'slug', $search_regions, 'job_listing_region' );
			$selected_region = $term->term_id;
		}
	} elseif (  ! empty( $atts['regions'] ) ) {
		if ( is_numeric( $atts['regions'] ) ) {
			$selected_region = intval( $atts['regions'] );
		} else {
			$term = get_term_by( 'slug', $atts['regions'], 'job_listing_region' );
			$selected_region = $term->term_id;
		}
	}


	$parent = $parent_second = $parent_third = 0;
	$first_select = $second_select = $third_select = $fourth_select = 0;

	if ( !empty($selected_region) ) {
		$level = cityo_get_the_level($selected_region);
		if ( $level == 0 ) {
			$parent = $first_select = $selected_region;
		} elseif ( $level == 1 ) {
			$term = get_term($selected_region);
			if ( $term ) {
				$parent_term = get_term($term->parent);
				$parent = $first_select = $parent_term->term_id;
				$parent_second = $second_select = $term->term_id;
			}
		} elseif ( $level == 2 ) {
			$term = get_term($selected_region);
			if ( $term ) {
				$third_select = $term->term_id;
				// second
				$second_parent_term = get_term($term->parent);
				$parent_second = $second_select = $second_parent_term->term_id;
				// first
				$first_parent_term = get_term($second_parent_term->parent);
				$parent = $first_select = $first_parent_term->term_id;
			}
		} elseif ( $level == 3 ) {
			$term = get_term($selected_region);
			if ( $term ) {
				$fourth_select = $term->term_id;
				// third
				$third_parent_term = get_term($term->parent);
				$parent_third = $third_select = $third_parent_term->term_id;
				// second
				$second_parent_term = get_term($third_parent_term->parent);
				$parent_second = $second_select = $second_parent_term->term_id;
				// first
				$first_parent_term = get_term($second_parent_term->parent);
				$parent = $first_select = $first_parent_term->term_id;
			}
		}
	}


	$nb_fields = cityo_get_config('submit_listing_region_nb_fields', '1');

	$region1_text = cityo_get_config('submit_listing_region_1_field_label') ? strtolower(cityo_get_config('submit_listing_region_1_field_label')) : '';
?>
	
		<?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
			<div class="col-sm-6 list-inner-full">
		<?php } ?>
		    <div class="field-region field-region1">
			    <select class="select-field-region select-field-region1" data-next="2" autocomplete="off" name="job_region_select[]" data-placeholder="<?php echo sprintf(esc_attr__('Filter by %s', 'cityo'), $region1_text); ?>">
			    	<option value=""><?php echo sprintf(esc_html__('Filter by %s', 'cityo'), $region1_text); ?></option>
				    <?php
				    if ( ! empty( $first_regions ) && ! is_wp_error( $first_regions ) ) {
					    foreach ($first_regions as $region) {
					    	$selected_attr = '';
					    	if ( $region->term_id == $first_select ) {
					    		$selected_attr = 'selected="selected"';
					    	}
					      	?>
					      	<option value="<?php echo esc_attr($region->slug); ?>" <?php echo trim($selected_attr); ?>><?php echo esc_html($region->name); ?></option>
					      	<?php  
					    }
				    }
				    ?>
			    </select>
		    </div>
		<?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
			</div>
		<?php } ?>
		<?php if ( $nb_fields == '2' || $nb_fields == '3' || $nb_fields == '4' ) {
			$region2_text = cityo_get_config('submit_listing_region_2_field_label') ? strtolower(cityo_get_config('submit_listing_region_2_field_label')) : '';
		?>
			<?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				<div class="col-sm-6 list-inner-full">
			<?php } ?>
		    <div class="field-region field-region2">
		    	<select class="select-field-region select-field-region2" data-next="3" autocomplete="off" name="job_region_select[]" data-placeholder="<?php echo sprintf(esc_attr__('Filter by %s', 'cityo'), $region2_text); ?>">
		    		<option value=""><?php echo sprintf(esc_html__('Filter by %s', 'cityo'), $region2_text); ?></option>
		    		<?php
		    		if ( !empty($parent) ) {
			    		$second_regions = get_terms('job_listing_region', array(
			                'orderby' => 'count',
			                'hide_empty' => 0,
			                'parent' => $parent,
			            ));
			            if ( ! empty( $second_regions ) && ! is_wp_error( $second_regions ) ) {
			            	foreach ($second_regions as $region) {
						    	$selected_attr = '';
						    	if ( $region->term_id == $second_select  ) {
						    		$selected_attr = 'selected="selected"';
						    	}
						      	?>
						      	<option value="<?php echo esc_attr($region->slug); ?>" <?php echo trim($selected_attr); ?>><?php echo esc_html($region->name); ?></option>
						      	<?php  
						    }
			            }
			    	}
		    		?>
		    	</select>
		    </div>
		    <?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if ( $nb_fields == '3' || $nb_fields == '4' ) {
			$region3_text = cityo_get_config('submit_listing_region_3_field_label') ? strtolower(cityo_get_config('submit_listing_region_3_field_label')) : '';
		?>
			<?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				<div class="col-sm-6 list-inner-full">
			<?php } ?>
			<div class="field-region field-region3">
		    	<select class="select-field-region select-field-region3" data-next="4" autocomplete="off" name="job_region_select[]" data-placeholder="<?php echo sprintf(esc_attr__('Filter by %s', 'cityo'), $region3_text); ?>">
		    		<option value=""><?php echo sprintf(esc_html__('Filter by %s', 'cityo'), $region3_text); ?></option>
		    		<?php
		    		if ( !empty($parent_second) ) {
			    		$third_regions = get_terms('job_listing_region', array(
			                'orderby' => 'count',
			                'hide_empty' => 0,
			                'parent' => $parent_second,
			            ));
			            if ( ! empty( $third_regions ) && ! is_wp_error( $third_regions ) ) {
			            	foreach ($third_regions as $region) {
						    	$selected_attr = '';
						    	if ( $region->term_id == $third_select ) {
						    		$selected_attr = 'selected="selected"';
						    	}
						      	?>
						      	<option value="<?php echo esc_attr($region->slug); ?>" <?php echo trim($selected_attr); ?>><?php echo esc_html($region->name); ?></option>
						      	<?php  
						    }
			            }
			    	}
		    		?>
		    	</select>
		    </div>
		    <?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if ( $nb_fields == '4' ) {
			$region4_text = cityo_get_config('submit_listing_region_4_field_label') ? strtolower(cityo_get_config('submit_listing_region_4_field_label')) : '';
		?>
			<?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				<div class="col-sm-6 list-inner-full">
			<?php } ?>
		    <div class="field-region field-region4">
		    	<select class="select-field-region select-field-region4" data-next="5" autocomplete="off" name="job_region_select[]" data-placeholder="<?php echo sprintf(esc_attr__('Filter by %s', 'cityo'), $region4_text); ?>">
		    		<option value=""><?php echo sprintf(esc_html__('Filter by %s', 'cityo'), $region4_text); ?></option>
		    		<?php
		    		if ( !empty($parent_third) ) {
			    		$fourth_regions = get_terms('job_listing_region', array(
			                'orderby' => 'count',
			                'hide_empty' => 0,
			                'parent' => $parent_third,
			            ));
			            if ( ! empty( $fourth_regions ) && ! is_wp_error( $fourth_regions ) ) {
			            	foreach ($fourth_regions as $region) {
						    	$selected_attr = '';
						    	if ( $region->term_id == $fourth_select ) {
						    		$selected_attr = 'selected="selected"';
						    	}
						      	?>
						      	<option value="<?php echo esc_attr($region->slug); ?>" <?php echo trim($selected_attr); ?>><?php echo esc_html($region->name); ?></option>
						      	<?php  
						    }
			            }
			    	}
		    		?>
		    	</select>
		    </div>
		    <?php if ( !empty($filter_version) && $filter_version == 'v2' ) { ?>
				</div>
			<?php } ?>
		<?php } ?>
	
<?php } ?>