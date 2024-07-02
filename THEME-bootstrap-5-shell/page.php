<?php get_header(); ?>
<div class="row">
<div class="col blog-main">
  <div class="blog-post">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h1 class="article-title">
      <?php the_title(); ?>
    </h1>
    <div class="row">
      <div class="col-md-9">
        <div class="article-content">
          <?php the_content(); ?>
          <div class="clear"> </div>
        </div>
      </div>
      <div class="hidden-xs hidden-sm col-md-3">
        <?php get_sidebar(); ?>
      </div>
    </div>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
