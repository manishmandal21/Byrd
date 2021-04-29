<?php
$post_format = get_post_format();
global $post;
$posttags = get_the_tags();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-detail'); ?>>
    <div class="entry-content-detail <?php echo  (!has_post_thumbnail() ? '' : 'has-thumb'); ?>">
        <?php if ( $post_format == 'gallery' ) {
            $gallery = cityo_post_gallery( get_the_content(), array( 'size' => 'full' ) );
        ?>
            <div class="entry-thumb <?php echo  (empty($gallery) ? 'no-thumb' : ''); ?>">
                <?php echo trim($gallery); ?>
            </div>
        <?php } elseif( $post_format == 'link' ) {
                $format = cityo_post_format_link_helper( get_the_content(), get_the_title() );
                $title = $format['title'];
                $link = cityo_get_link_attributes( $title );
                $thumb = cityo_post_thumbnail('', $link);
                echo trim($thumb);
            } else { ?>
            <div class="entry-thumb">
                <?php
                    $thumb = cityo_post_thumbnail();
                    echo trim($thumb);
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="wrapper-small">
        <div class="box-list-2 t-r-noradius">
            <div class="info-top clearfix">
                <div class="info-meta">
                    <span class="author"><i class="flaticon-user"></i><?php the_author_posts_link(); ?></span>
                    <span class="date"><i class="flaticon-event-1"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
                    <span class="comment"><i class="flaticon-consulting-message"></i><?php comments_number( esc_html__('0 Comments', 'cityo'), esc_html__('1 Comment', 'cityo'), esc_html__('% Comments', 'cityo') ); ?></span>
                </div>
                <?php if (get_the_title()) { ?>
                    <h1 class="entry-title">
                        <?php the_title(); ?>
                    </h1>
                <?php } ?>
            </div>
            <div class="entry-description clearfix">
                <?php
                    if ( $post_format == 'gallery' ) {
                        $gallery_filter = cityo_gallery_from_content( get_the_content() );
                        echo trim($gallery_filter['filtered_content']);
                    } else {
                        the_content();
                    }
                ?>
            </div><!-- /entry-content -->
            <?php
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cityo' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'cityo' ) . ' </span>%',
                'separator'   => '',
            ) );
            ?>
            <div class="tags-detail clearfix">
                <?php cityo_post_tags(); ?>
            </div>
            <?php if( cityo_get_config('show_blog_social_share', false) ) {
                    get_template_part( 'template-parts/sharebox' );
                } ?>
            
        </div>
        <div class="box-list-2">
            <?php
                //Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true"><i class="fas fa-long-arrow-alt-right"></i></span> ' .
                        '<span class="clearfix"><span class="navi">' . esc_html__( 'Next', 'cityo' ) . '</span> ' .
                        '<span class="post-title">%title</span></span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="fas fa-long-arrow-alt-left"></i></span> ' .
                        '<span class="clearfix "><span class="navi"> ' . esc_html__( 'Prev', 'cityo' ) . '</span> ' .
                        '<span class="post-title">%title</span></span>',
                ) );
            ?>
        </div>
        <?php   if ( cityo_get_config('show_blog_releated', false) ): ?>
            <div class="box-list">
                <div class="related-posts">
                    <?php get_template_part( 'template-parts/posts-releated' ); ?>
                </div>
            </div>
            <?php

            endif;
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :?>
                <?php comments_template(); ?>
            <?php  endif;
        ?>
    </div>
</article>