<?php
$listing_is_claimed = get_post_meta( get_the_ID(), '_claimed', true );
if ( !$listing_is_claimed ) {
?>
	<div class="widget widget-claim">
		<?php esc_html_e('Claim your free business page to have your changes published immediately.', 'cityo'); ?>
		<a href="#claim-listing" class="claim-this-business" data-id="<?php the_ID(); ?>"><?php esc_html_e( 'Claim this business', 'cityo' ); ?></a>
	</div>
	<?php get_template_part( 'apus-cityo/claim/claim-form'); ?>
<?php
}