<?php
$thumbsize = !isset($thumbsize) ? cityo_get_blog_thumbsize() : $thumbsize;
$categories = get_the_category();
$thumb = cityo_display_post_thumb($thumbsize);
$post_format = get_post_format();
?>
<article <?php post_class('post post-grid-v3'); ?>>
    <div class="top-info <?php echo (!empty($thumb) && $post_format != 'audio' && $post_format != 'video' ) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php
            echo trim($thumb);
        ?>
        <div class="wrapper-date">
            <div class="year"><?php echo get_the_date( 'Y' ); ?></div>
            <span class="m-d"><?php echo get_the_date( 'M  d' ); ?></span>
        </div>
    </div>
    <div class="entry-content <?php echo !empty($thumb) ? 'has-thumb' : 'no-thumb'; ?>">
        <div class="top-infor">
            <?php if (get_the_title()) { ?>
                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
            <?php } ?>
            <?php if ( has_excerpt() ) { ?>
                <div class="description"><?php echo cityo_substring( get_the_excerpt(), 16, '...' ); ?></div>
            <?php }  ?>
        </div>
        <div class="bottom-link">
            <a href="<?php the_permalink(); ?>" class="read-more text-theme"><?php echo esc_html__('Read More','cityo') ?><i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>
</article>