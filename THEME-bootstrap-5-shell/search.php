<?php get_header(); ?>
<div class="row">
<div class="col blog-main">
  <div class="blog-post">
  <h1 class="page-title"> <?php printf( __( 'Search Results for: %s' ), '' . get_search_query() . '' ); ?> </h1>
  <?php if ( have_posts() ) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <h2 class="article-title"><a href="<?php the_permalink(); ?>">
    <?php the_title(); ?>
    </a></h2>
  <?php the_excerpt(); ?>
  <?php endwhile; endif; ?>
  <nav>
  <?php if ( $wp_query->max_num_pages > 1 ) : ?>
  <div class="prev">
    <?php previous_posts_link( __( 'Prev' ) ); ?>
  </div>
  <div class="next">
    <?php next_posts_link( __( 'Next' ) ); ?>
  </div>
  <?php endif; ?>
  </nav>
  </div>
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
