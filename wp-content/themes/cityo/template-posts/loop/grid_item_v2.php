<?php
$thumbsize = !isset($thumbsize) ? cityo_get_blog_thumbsize() : $thumbsize;
$categories = get_the_category();
$thumb = cityo_display_post_thumb($thumbsize);
$post_format = get_post_format();
?>
<article <?php post_class('post post-grid-v2'); ?>>
    <div class="top-info <?php echo (!empty($thumb) && $post_format != 'audio' && $post_format != 'video' ) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php
            echo trim($thumb);
        ?>
    </div>
    <div class="entry-content <?php echo !empty($thumb) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php if ( ! empty( $categories ) ) { ?>
            <div class="categories">
                <?php cityo_post_categories($post); ?>
            </div>
        <?php } ?>
        <?php if (get_the_title()) { ?>
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        <?php } ?>
    </div>
</article>