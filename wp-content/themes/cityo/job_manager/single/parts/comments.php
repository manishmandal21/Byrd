<?php
global $post;
if ( cityo_listing_review_enable($post->ID) ) : ?>
	
	<?php comments_template(); ?>
<?php endif; ?>