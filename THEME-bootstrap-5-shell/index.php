<?php get_header(); ?>
<div class="row">
<div class="col blog-main">
  <?php if ( have_posts() ): ?>
  <?php while ( have_posts() ) : the_post(); ?>
  <div class="blog-post">
    <a href="<?php the_permalink(); ?>" class="archive-title"><strong>
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
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
