<?php

function cityo_display_listing_logo_image( $post = null ) {
	if ( empty($post) ) {
		global $post;
	}

	$size = 'thumbnail';
	$attach_id = get_post_meta($post->ID, '_job_logo', true);
	if ( !empty($attach_id) ) {
		?>
		<div class="listing-logo">
			<div class="inner">
				<?php echo trim(cityo_get_attachment_thumbnail($attach_id, $size)); ?>
				<?php do_action( 'cityo-listings-logo-after', $post ); ?>
			</div>
		</div>
		<?php
	}
}

function cityo_display_listing_cover_image( $size = 'thumbnail', $link = true, $post = null ) {
	if ( empty($post) ) {
		global $post;
	}
	$post_id = $post->ID;
	if ( has_post_thumbnail( $post_id ) ) {
		$attach_id = esc_sql( get_post_thumbnail_id( $post_id ) );
		if ($link) { ?>
			<a class="listing-image-inner" href="<?php the_job_permalink($post); ?>">
		<?php }
		echo trim(cityo_get_attachment_thumbnail($attach_id, $size));
		if ($link) { ?>
			</a>
		<?php }
	}
}

function cityo_display_listing_claim_status($post) {
	if ( cityo_get_config('claim_enable', true) ) {
		$listing_is_claimed = get_post_meta( $post->ID, '_claimed', true );
		if ( $listing_is_claimed ) {
			echo '<span class="listing-claimed-icon" data-toggle="tooltip" title="'.esc_attr__('Claimed', 'cityo').'"><i class="fas fa-check"></i></span>';
		}
	}
}

function cityo_display_listing_location($post) {
	$location = get_post_meta($post->ID, '_job_location', true);
	if ( $location ) {
		?>
		<div class="listing-location listing-address">
			<a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>">
				<i class="flaticon-placeholder"></i><?php echo esc_html($location); ?>
			</a>
		</div>
		<?php
	}
}

function cityo_display_listing_phone($post) {
	$phone = get_post_meta($post->ID, '_job_phone', true);
	if ( $phone ) {
		?>
		<div class="listing-phone">
			<a href="tel:<?php echo esc_attr($phone); ?>">
				<i class="flaticon-call"></i><?php echo esc_html($phone); ?>
			</a>
		</div>
		<?php
	}
}

function cityo_display_time_status($post) {
	if ( cityo_get_config('listing_show_hour_status', true) ) {
		$status = cityo_get_current_time_status( $post->ID );

		if ( $status ) { ?>
			<div class="listing-time opening">
				<?php esc_html_e( 'Open', 'cityo' ); ?>
			</div>
		<?php } else { ?>
			<div class="listing-time closed">
				<?php esc_html_e( 'Closed', 'cityo' ); ?>
			</div>
		<?php }
	}
}

function cityo_display_listing_first_category($post) {
	$terms = get_the_terms( $post->ID, 'job_listing_category' );
	$firstTermHTML  = '';
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		$firstTerm = $terms[0];
		if ( ! $firstTerm == null ) {
			$icon = cityo_listing_category_icon($firstTerm);
			$firstTermHTML .= '<a href="'.get_term_link($firstTerm).'">'.$icon.$firstTerm->name.'</a>';
		}
	}
	if ( $firstTermHTML ) {
		?>
		<div class="listing-category">
			<?php echo trim($firstTermHTML); ?>
		</div>
		<?php
	}
}

function cityo_display_listing_all_categories($post) {
	$terms = get_the_terms( $post->ID, 'job_listing_category' );
	$termHTML  = '';
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		$i=1; foreach ($terms as $term) {
			$icon = cityo_listing_category_icon($term);
			$termHTML .= '<a href="'.get_term_link($term).'">'.$icon.$term->name.'</a>'.($i < count($terms) ? ', ' : '');
		$i++;}
	}
	if ( $termHTML ) {
		?>
		<div class="listing-category">
			<?php echo trim($termHTML); ?>
		</div>
		<?php
	}
}
function cityo_display_listing_all_types($post) {
	$terms = get_the_terms( $post->ID, 'job_listing_type' );
	$termHTML  = '';
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		$i=1; foreach ($terms as $term) {
			$icon = cityo_listing_category_icon($term);
			$termHTML .= '<a href="'.get_term_link($term).'">'.$icon.$term->name.'</a>'.($i < count($terms) ? ', ' : '');
		$i++;}
	}
	if ( $termHTML ) {
		?>
		<div class="listing-category">
			<?php echo trim($termHTML); ?>
		</div>
		<?php
	}
}

function cityo_display_listing_review($post) {
	if ( cityo_listing_review_rating_enable() ) {
		$total_rating = get_post_meta( $post->ID, '_average_rating', true );
		if ( $total_rating > 0 ) {
			$rating_mode = cityo_get_config('listing_review_mode', 10);
			cityo_display_listing_review_html($total_rating, $rating_mode);
		}
	}
}

function cityo_display_listing_review_html($total_rating, $rating_mode) {
	?>
	<div class="listing-review">
		<span class="review-avg"><?php echo number_format((float)$total_rating, 1, '.', ''); ?> <span class="total-rating">/ <?php echo trim(!empty($rating_mode) ? $rating_mode : 10); ?></span> <span class="review-text"><?php esc_html_e('Ratings', 'cityo'); ?></span></span>
	</div>
	<?php
}

function cityo_display_price_range($post) {
	$price_from = get_post_meta($post->ID, '_job_price_from', true);
	$price_to = get_post_meta($post->ID, '_job_price_to', true);
	if ( $price_from || $price_to ) {
		?>
		<span class="price-range">
			<?php cityo_listing_display_price($price_from); ?>
			<?php if ( $price_to ) { ?>
				- <?php cityo_listing_display_price($price_to); ?>
			<?php } ?>
		</span>
		<?php
	}
}

function cityo_display_listing_card_btn($post) {
	?>
	<div class="top-imformation ali-right">
		<div class="listing-btn-wrapper listing-preview-wrapper">
			<a href="#preview-<?php echo esc_attr($post->ID); ?>" class="listing-preview" data-id="<?php echo esc_attr($post->ID); ?>" title="<?php esc_attr_e('Preview', 'cityo'); ?>"><i class="flaticon-zoom-in"></i><span class="preview-text"><?php esc_html_e('Preview', 'cityo'); ?></span></a>
		</div>
		<?php Cityo_Bookmark::display_bookmark_btn($post); ?>
		<?php do_action( 'cityo-listings-card-btn', get_the_ID() ); ?>
	</div>
	<?php
}

function cityo_display_listing_card_bookmark_btn($post) {
	?>
	<div class="top-imformation ali-right">
		<?php Cityo_Bookmark::display_bookmark_btn($post); ?>
		<?php do_action( 'cityo-listings-card-btn', get_the_ID() ); ?>
	</div>
	<?php
}

function cityo_listing_display_price($price, $echo = true) {
	$price = cityo_price_format_number( $price );
	
	$symbol = cityo_get_config('listing_currency_symbol', '$');
	$show_after = cityo_get_config('listing_currency_symbol_after_amount', 0);
	
	$currency_symbol = ! empty( $symbol ) ? $symbol : '$';
	$currency_show_symbol_after = $show_after ? true : false;
	$price_html = $price;
	if ( ! empty( $currency_symbol ) ) {
		if ( $currency_show_symbol_after ) {
			$price_html = sprintf('<span class="price">%s</span><span class="currency-symbol">%s</span>', $price, $currency_symbol);
		} else {
			$price_html = sprintf('<span class="currency-symbol">%s</span><span class="price">%s</span>', $currency_symbol, $price);
		}
	}
	if ( $echo ) {
		echo trim($price_html);
	} else {
		return $price_html;
	}
}

function cityo_listing_display_price_range($post) {
	$price_range = get_post_meta($post->ID, '_job_price_range', true);
	$price_range_labels = cityo_job_manager_price_range_icons();
	if ( $price_range && isset($price_range_labels[$price_range])) {
		$labels = $price_range_labels[$price_range];
		?>
		<div class="listing-price-range" data-placement="top" data-toggle="tooltip" title="<?php echo esc_attr($labels['label']); ?>">
			<?php echo esc_attr($labels['icon']); ?>
		</div>
		<?php
	}
}

function cityo_display_categories_icon( $terms ) {
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		foreach ($terms as $term) {
			$icon = cityo_listing_category_icon($term);
			
			if ( !empty($icon) ) {
			?>
				<a href="<?php echo esc_url( get_term_link($term->term_id, 'job_listing_category') ); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $term->name); ?>">
					<?php echo trim($icon); ?>
				</a>
			<?php
			}
		}
	}
}

function cityo_listing_category_icon( $term ) {
	$html = '';

	$icon_type_value = get_term_meta( $term->term_id, 'apus_icon_type', true );
	$icon_font_value = get_term_meta( $term->term_id, 'apus_icon_font', true );
	$icon_image_value = get_term_meta( $term->term_id, 'apus_icon_image', true );
	if ( $icon_type_value == 'font' && !empty($icon_font_value) ) {
		$html = '<i class="'.esc_attr($icon_font_value).'"></i>';
	} elseif ( $icon_type_value == 'image' && !empty($icon_image_value) ) {
		$image_url = wp_get_attachment_image_src($icon_image_value, 'full');
		if ( !empty($image_url[0]) ) {
			$html = '<img src="'.esc_url($image_url[0]).'" alt="'.esc_attr__( 'icon', 'cityo' ).'" />';
		}
	}
	$color_value = get_term_meta( $term->term_id, 'apus_color', true );
	$style = '';
	if ( !empty($color_value) ) {
		$style = ' style="background: '.$color_value.';"';
	}
	if($html){
		$html = '<span class="icon-cate"'.$style.'>'.$html.'</span>';
	}
	return $html;
}

function cityo_job_manager_price_range_label($labels) {
	$labels = cityo_job_manager_price_range_icons();
	$return = array( 'notsay' => esc_html__('Prefer not to say', 'cityo') );
	foreach ($labels as $key => $label) {
		$return[$key] = $label['icon'] .' - '.$label['label'];
	}
	return $return;
}

// price range label
add_filter( 'apus_cityo_price_ranges', 'cityo_job_manager_price_range_label' );


function cityo_listing_title($post) {
	?>
	<h1 class="entry-title" itemprop="name">
		<?php echo get_the_title($post); ?>
	</h1>
	<?php
}

function cityo_listing_claimed_status($post) {
	if ( cityo_get_config('claim_enable', true) ) {
		$listing_is_claimed = get_post_meta( $post->ID, '_claimed', true );
		if ( $listing_is_claimed ) {
			echo '<span class="listing-claimed-icon" data-toggle="tooltip" title="'.esc_attr__('Claimed', 'cityo').'"><i class="far fa-check-circle"></i></span>';
		}
	}
}

function cityo_listing_tagline($post) {
	$job_tagline = get_post_meta( $post->ID, '_job_tagline', true );
	if ( $job_tagline ) {
		echo '<div class="listing-tagline">'.$job_tagline.'</div>';
	}
}

function cityo_listing_review_btn($post) {
	if ( cityo_listing_review_enable($post->ID) ) {
        echo '<div class="listing-review-btn"><a class="listing-reviews" href="#listing-reviews"><i class="flaticon-consulting-message"></i> '.esc_html__('Submit Review', 'cityo').'</a></div>';
	}
}

function cityo_listing_single_socials_share($post) {
	if ( cityo_get_config('show_listing_social_share', true) ) { ?>
		<div class="sharing-popup">
			<a href="#" class="share-popup action-button" title="<?php esc_attr_e('Social Share', 'cityo'); ?>">
				<i class="flaticon-share"></i> <?php esc_html_e('Share', 'cityo'); ?>
			</a>
			<div class="share-popup-box">
				<?php get_template_part( 'template-parts/sharebox' ); ?>
			</div>
		</div>
	<?php }
}

function cityo_listing_single_address($post) {
	$location = get_post_meta( $post->ID, '_job_location', true );
	if ( $location ) {
		?>
		<div class="listing-address">
			<h4><?php esc_html_e('Address', 'cityo'); ?></h4>
			<div class="listing-item-inner">
				<?php echo esc_html($location); ?>
			</div>
		</div>
		<?php
	}
}

function cityo_listing_single_startdate($post) {
	$start_date = get_post_meta( $post->ID, '_job_start_date', true );
	if ( $start_date ) {
		$start_date = strtotime($start_date);
		?>
		<div class="listing-starttime">
			<h4><?php esc_html_e('Start Time', 'cityo'); ?></h4>
			<div class="listing-item-inner">
				<div class="time"><?php echo date(get_option('time_format'), $start_date); ?></div>
				<div class="date"><?php echo date(get_option('date_format'), $start_date); ?></div>
			</div>
		</div>
		<?php
	}
}

function cityo_listing_single_finishdate($post) {
	$finish_date = get_post_meta( $post->ID, '_job_finish_date', true );
	if ( $finish_date ) {
		$finish_date = strtotime($finish_date);
		?>
		<div class="listing-finishtime">
			<h4><?php esc_html_e('Finish Time', 'cityo'); ?></h4>
			<div class="listing-item-inner">
				<div class="time"><?php echo date(get_option('time_format'), $finish_date); ?></div>
				<div class="date"><?php echo date(get_option('date_format'), $finish_date); ?></div>
			</div>
		</div>
		<?php
	}
}

function cityo_listing_posted_by($post) {
	?>
	<div class="author"><?php echo esc_html__('Posted By: ','cityo'); the_author_posts_link(); ?></div>
	<?php
}

function cityo_listing_categories($post) {
	ob_start();
	$terms = get_the_terms( $post->ID, 'job_listing_category' );
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		$i = 0;
		foreach ($terms as $term) {
			?>
				<?php if($i != 0) echo ', ';?>
				<a href="<?php echo esc_url( get_term_link($term->term_id, 'job_listing_category') ); ?>" title="<?php echo esc_attr( $term->name); ?>">
					<?php echo esc_attr( $term->name); ?>
				</a>
			<?php
			$i++;
		}
	}
	$term_html = ob_get_clean();
	?>
	<div class="categories"><?php echo trim($term_html); ?></div>
	<?php
}

function cityo_listing_video($post) {
	$video       = get_post_meta($post->ID, '_job_video', true);
	$video_embed = false;
	$filetype    = wp_check_filetype( $video );

	if ( ! empty( $video ) ) {
		// FV WordPress Flowplayer Support for advanced video formats.
		if ( shortcode_exists( 'flowplayer' ) ) {
			$video_embed = '[flowplayer src="' . esc_url( $video ) . '"]';
		} elseif ( ! empty( $filetype['ext'] ) ) {
			$video_embed = wp_video_shortcode( array( 'src' => $video ) );
		} else {
			$video_embed = wp_oembed_get( $video );
		}
	}

	$video_embed = apply_filters( 'the_company_video_embed', $video_embed, $post );

	if ( $video_embed ) {
		echo '<div class="company_video">' . $video_embed . '</div>'; // WPCS: XSS ok.
	}
}

function cityo_listing_regions($post) {
	$terms = get_the_terms( $post->ID, 'job_listing_region' );

	$termsHTML  = '';
	if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
		$regions = array();
		cityo_listing_regions_walk($terms, 0, $regions);

		$regions = array_reverse($regions, true);
		$i = 1; foreach ($regions as $term) {
			$termsHTML .= '<a href="'.get_term_link($term).'">'.$term->name.'</a>'.($i < count($regions) ? ', ' : '');
			$i++;
		}
	}

	return $termsHTML;
}

function cityo_listing_regions_walk( $terms, $id_parent, &$dropdown ) {
    foreach ( $terms as $key => $term ) {
        if ( $term->parent == $id_parent ) {
            $dropdown = array_merge( $dropdown, array( $term ) );
            unset($terms[$key]);
            cityo_listing_regions_walk( $terms, $term->term_id,  $dropdown );
        }
    }
}

function cityo_listing_menu_prices($items_data) {
	$html = '';
	if ( !empty($items_data) && is_array($items_data) ) {
		foreach ($items_data as $section) {

			$section_title = !empty($section['section_title']) ? $section['section_title'] : '';
			$titles_value = !empty($section['title']) ? $section['title'] : array();
			$items_prices = !empty($section['price']) ?  $section['price'] : array();
			$items_descriptions = !empty($section['description']) ? $section['description'] : array();
			
			if ( cityo_check_menu_prices_empty($section) ) {
				$html .= '<div class="col-xs-12">
						<div class="menu-prices-wrapper">';
				if ( !empty($section_title) ) {
					$html .= '<h3 class="title-price">'.trim($section_title).'</h3>';
				}
				$html .= '<ul class="listing-menu-prices-list">';
				foreach ($titles_value as $key => $title_value) {
					$price_value = !empty($items_prices[$key]) ? $items_prices[$key] : '';
					$description_value = !empty($items_descriptions[$key]) ? $items_descriptions[$key] : '';
				
					$html .= '<li>
							<h5>'.$title_value.'<span class="price">'.$price_value.'</span></h5>
							<div class="description">
								'.$description_value.'
							</div>
						</li>';
				}
				$html .= '</ul>
						</div>
					</div>';
			}
		}
	}
	return $html;
}

function cityo_listing_event_schedule($items_data) {
	$html = '';
	

	if ( !empty($items_data) && is_array($items_data) ) {
		$html .= '<div class="event-schedule-wrapper">';
			$html .= '<div class="panel-group" id="event-schedule-accordion">';
			$i = 1;
			foreach ($items_data as $data) {
				$title = !empty($data['title']) ? $data['title'] : '';
				$time = !empty($data['time']) ? $data['time'] : 0;
				$description = !empty($data['description']) ? $data['description'] : '';
				
				if ( !empty($title) && !empty($description) ) {
					$html .= '
						<div class="panel panel-default">
							<div class="panel-heading '.($i == 1 ? ' active' : '').'" id="event-schedule-heading-' . $i.'">
								<a data-toggle="collapse" href="#event-schedule-collapse-' . $i.'" aria-parent="event-schedule-accordion">
									<div class="time">'.esc_html( gmdate( get_option( 'time_format' ), $time ) ).'</div>
						          	<h5>'.$title.'</h5>
						        </a>
							</div>
							<div id="event-schedule-collapse-' . $i.'" class="panel-collapse collapse '.($i == 1 ? 'in ' : '').'">
								<div class="panel-body description">
									'.$description.'
								</div>
							</div>
						</div>';
					$i++;
				}
			}
			$html .= '</div>';
		$html .= '</div>';
	}

	return $html;
}

function cityo_listing_event_sponsors($items_data) {
	$html = '';
	$increase = 1;
	if ( !empty($items_data) && is_array($items_data) ) {
		foreach ($items_data as $data) {
			$img = !empty($data['img']) ? $data['img'] : '';
			$url = !empty($data['url']) ? $data['url'] : '';
			$title = !empty($data['title']) ? $data['title'] : '';
			
			if ( !empty($img) ) {
				if ( is_numeric( $img ) ) {
					$image_src = wp_get_attachment_image_src( absint( $img ), 'full' );
					$image_src = $image_src ? $image_src[0] : '';
				} else {
					$image_src = $img;
				}

				if($increase % 3 == 1){
					$html .= '<div class="list-sponsor">';
				}

					$html .= '<div class="col-xs-4">';
						$html .= '<div class="item-sponsor">';
						if ( $url ) {
							$html .= '<a href="'.esc_url($url).'" title="'.esc_attr($title).'">';
						}
							$html .= '<img src="'.esc_url($image_src).'" alt="'.esc_attr($title).'">';
						if ( $url ) {
							$html .= '</a>';
						}
						$html .= '</div>';
					$html .= '</div>';

				if(($increase % 3 == 0) || ($increase == count($items_data)) ){
					$html .= '</div>';
				}
				$increase ++;
			}
		}
		if ( !empty($html) ) {
			$html = '<div class="event-sponsors-wrapper row">'.$html.'</div>';
		}
	}
	return $html;
}

function cityo_listing_event_speakers($items_data) {
	$html = '';
	if ( !empty($items_data) && is_array($items_data) ) {
		$html .= '<div class="event-speakers-wrapper slick-carousel" data-carousel="slick" data-items="3" data-medium="3" data-smallmedium="2" data-extrasmall="2" data-smallest="2" data-pagination="true" data-nav="false">';
		foreach ($items_data as $data) {
			$img = !empty($data['img']) ? $data['img'] : '';
			$job = !empty($data['job']) ? $data['job'] : '';
			$title = !empty($data['title']) ? $data['title'] : '';
			$facebook = !empty($data['facebook']) ? $data['facebook'] : '';
			$twitter = !empty($data['twitter']) ? $data['twitter'] : '';
			$google_plus = !empty($data['google_plus']) ? $data['google_plus'] : '';
			$linkedin = !empty($data['linkedin']) ? $data['linkedin'] : '';
			
			if ( !empty($img) && !empty($title) ) {
				if ( is_numeric( $img ) ) {
					$image_src = wp_get_attachment_image_src( absint( $img ), 'full' );
					$image_src = $image_src ? $image_src[0] : '';
				} else {
					$image_src = $img;
				}
				$html .= '<div class="item">';
					$html .= '<div class="item-speaker">';
					
						$html .= '<div class="avartar-speaker">';
							if ( $facebook || $twitter || $google_plus || $linkedin ) {
								$html .= '<ul class="socials">';
									if ( $facebook ) {
										$html .= '<li><a href="'.esc_url($facebook).'"><i class="fab fa-facebook-f"></i></a></li>';
									}
									if ( $twitter ) {
										$html .= '<li><a href="'.esc_url($twitter).'"><i class="fab fa-twitter"></i></a></li>';
									}
									if ( $google_plus ) {
										$html .= '<li><a href="'.esc_url($google_plus).'"><i class="fab fa-google-plus-g"></i></a></li>';
									}
									if ( $linkedin ) {
										$html .= '<li><a href="'.esc_url($linkedin).'"><i class="fab fa-linkedin-in"></i></a></li>';
									}
								$html .= '</ul>';
							}
							$html .= '<img src="'.esc_url($image_src).'" alt="'.esc_attr($title).'">';
						$html .= '</div>';

						$html .= '<div class="bottom-speaker">';
							if ( $title ) {
								$html .= '<h3 class="title">'.$title.'</h3>';
							}
							if ( $job ) {
								$html .= '<div class="job">'.$job.'</div>';
							}
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			}
		}
		$html .= '</div>';
	}
	return $html;
}

function cityo_listing_for_search_distance($post) {
	global $cityo_distances;
	if ( !empty($cityo_distances[$post->ID]) && !empty($cityo_distances[$post->ID]->distance) ) {
		$distance_type = cityo_get_config('listing_filter_distance_unit', 'km');
		?>
		<div class="listing-distance"><?php echo round($cityo_distances[$post->ID]->distance, 1).' '.$distance_type; ?></div>
		<?php
	}
}

function cityo_display_map_data( $post ) {
	$ouput = 'data-latitude="'.esc_attr( $post->geolocation_lat ).'" data-longitude="'.esc_attr( $post->geolocation_long ).'" data-img="'.esc_attr( cityo_get_post_image_src( $post->ID, 'cityo-card-image' ) ).'" data-thumb="'.esc_attr( cityo_get_post_image_src( $post->ID, 'thumbnail' ) ).'" data-permalink="'.get_the_job_permalink( $post ).'"';
	return $ouput;
}
if(!function_exists('cityo_listings_grid_place_metas_before')){
    function cityo_listings_grid_place_metas_before(){
        echo '<div class="left-inner">';
    }
}
if(!function_exists('cityo_listings_grid_place_metas_after')){
    function cityo_listings_grid_place_metas_after(){
        echo '</div>';
    }
}
if(!function_exists('cityo_listings_list_place_metas_before')){
    function cityo_listings_list_place_metas_before(){
        echo '<div class="left-inner">';
    }
}
if(!function_exists('cityo_listings_list_place_metas_after')){
    function cityo_listings_list_place_metas_after(){
        echo '</div>';
    }
}

add_action( 'cityo-listings-logo-after', 'cityo_display_listing_claim_status', 10, 1);





