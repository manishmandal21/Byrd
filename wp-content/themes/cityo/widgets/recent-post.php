<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $number_post
);

$query = new WP_Query($args);
if($query->have_posts()):
?>
<div class="widget-post-recent">
<ul class="post-recent">
<?php
	while($query->have_posts()):$query->the_post();
	global $post;
	$cat = wp_get_post_categories( $post->ID );
?>
	<li>
		<article class="post">
		    <div class="entry-content clearfix">
                <?php if ( has_post_thumbnail() ) { ?>
	                <div class="content-left">
				        <?php echo cityo_display_post_thumb('90x80'); ?>
				    </div>
			    <?php } ?>
		        <div class="content-body">
		          <?php
		              if (get_the_title()) {
		              ?>
		                  <h4 class="entry-title">
		                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                  </h4>
		              <?php
		          }
		          ?>
		          <div class="date"><?php the_time( get_option('date_format', 'd M, Y') ); ?> <span class="author"><?php echo esc_html__('by ','cityo'); the_author_posts_link(); ?></span></div>
		        </div>
		    </div>
		</article>
	</li>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
</ul>
</div>
<?php endif; ?>