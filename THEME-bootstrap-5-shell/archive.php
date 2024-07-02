<?php get_header(); ?>
<div class="row">
<div class="col blog-main">
  <div class="blog-post">
    <?php if( is_author() ): ?>
    <div class="author-box">
      <?php
         $fname = get_the_author_meta('first_name');
         $lname = get_the_author_meta('last_name');
         ?>
      <p><strong class="archive-title"><?php echo trim( "$fname $lname" ); ?></strong></p>
      <p><?php echo the_author_description(); ?></p>
    </div>
    <?php elseif( is_category() ): ?>
    <h1 class="article-title">Category:
      <?php single_cat_title(); ?>
    </h1>
    <?php elseif( is_tag() ): ?>
    <h1 class="article-title">Tag:
      <?php single_tag_title(); ?>
    </h1>
    <?php elseif( is_year() ): ?>
    <h1 class="article-title">Archive for
      <?php the_time('Y'); ?>
    </h1>
    <?php elseif( is_month() ): ?>
    <h1 class="article-title">Archive for
      <?php the_time('F Y'); ?>
    </h1>
    <?php else: ?>
    <h1 class="article-title">Archive</h1>
    <?php endif; ?>
    <?php if ( have_posts() ): ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="archive-post"> <a href="<?php the_permalink(); ?>" class="archive-title"><strong>
      <?php the_title(); ?>
      </strong></a>
      <?php the_excerpt(); ?>
      <a href="<?php the_permalink(); ?>" class="read-more">[ Read More ]</strong></a> </div>
    <?php endwhile; wp_reset_query(); endif; ?>
    <nav>
	<?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <div class="prev">
      <?php next_posts_link( __( '&larr; Older posts' ) ); ?>
    </div>
    <div class="next">
      <?php previous_posts_link( __( 'Newer posts &rarr;' ) ); ?>
    </div>
    <?php endif; ?>
    </nav>
  </div>
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
