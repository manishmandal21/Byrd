<?php $thumbsize = !isset($thumbsize) ? cityo_get_blog_thumbsize() : $thumbsize;?>
<?php $categories = get_the_category(); ?>
<article <?php post_class('post list-noimages'); ?>>
    <div class="row list-inner">
        <div class="col-sm-<?php echo esc_attr(!empty($thumb) ? '12' : '12'); ?> info">
          <div class="info-content">
            <?php
                if (get_the_title()) {
                ?>
                    <h3 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php echo cityo_substring( get_the_title(), 7, '' ); ?></a>
                    </h3>
                <?php
            }
            ?>
            <div class="meta">
                <?php if ( ! empty( $categories ) ) { ?>
                    <span class="categories">
                        <?php echo esc_html( $categories[0]->name ); ?>
                    </span>
                <?php } ?>
                <span class="date"><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
            </div>
          </div>
        </div>
    </div>
</article>