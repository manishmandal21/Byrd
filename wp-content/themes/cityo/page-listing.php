<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Cityo
 * @since Cityo 1.0
 */
/*
*Template Name: Page Listings
*/

get_header();
$layout_version = cityo_get_listing_archive_version();
if ($layout_version == 'default' || $layout_version == 'default-full') {
	cityo_render_breadcrumbs();
}
?>
	<section id="main-container" class="inner">
		
		<div id="primary" class="content-area">
			<div class="entry-content">
				<div id="main" class="site-main">
				<?php
					global $wp_query;
					
					$pagination = '';
					if ( !cityo_get_config('listing_show_loadmore', true) ) {
						$pagination = 'show_pagination="true"';
					}
					$shortcode = '[jobs show_tags="true" show_more="false" '.$pagination.' orderby="featured" order="DESC"]';
					echo do_shortcode(  $shortcode );
				?>
				</div><!-- #main -->
			</div>
		</div><!-- #primary -->
	</section>
<?php get_footer(); ?>