<?php
$thumbsize = !isset($thumbsize) ? cityo_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$categories = get_the_category();
$thumb = cityo_display_post_thumb($thumbsize);
$post_format = get_post_format();
?>
<article <?php post_class('post post-grid'); ?>>
    <div class="top-info <?php echo (!empty($thumb) && $post_format != 'audio' && $post_format != 'video' ) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php
            echo trim($thumb);
        ?>
    </div>
    <div class="entry-content <?php echo !empty($thumb) ? 'has-thumb' : 'no-thumb'; ?>">
        <div class="info-meta">
            <span class="author"><i class="flaticon-user"></i><?php the_author_posts_link(); ?></span>
            <span class="date"><i class="flaticon-event-1"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
            <span class="comment"><i class="flaticon-consulting-message"></i><?php comments_number( esc_html__('0 Comments', 'cityo'), esc_html__('1 Comment', 'cityo'), esc_html__('% Comments', 'cityo') ); ?></span>

        </div>
        <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
            <span class="post-sticky"><span><?php echo esc_html__('Featured','cityo'); ?></span></span>
        <?php endif; ?>
        <?php if (get_the_title()) { ?>
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        <?php } ?>
        <?php if ( has_excerpt() ) { ?>
            <div class="description"><?php echo cityo_substring( get_the_excerpt(), 70, '...' ); ?></div>
        <?php } ?>
        <a href="<?php the_permalink(); ?>" class="read-more text-theme"><?php echo esc_html__('Read More','cityo') ?><i class="fas fa-long-arrow-alt-right"></i></a>
    </div>
</article>