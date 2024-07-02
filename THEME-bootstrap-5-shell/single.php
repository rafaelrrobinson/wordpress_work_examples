<?php get_header(); ?>
<div class="row">
<div class="col blog-main">
  <div class="blog-post">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h1 class="article-title">
      <?php the_title(); ?>
    </h1>
    <div class="article-date">
      <strong>By: <?php echo get_the_author_meta('display_name'); ?></strong>
      <?php the_date('m.d.y'); ?>
      - <?php
        if(is_singular('pictorials')) {
          echo 'Pictorials';
        } else {
          $categories = get_the_category();
          echo $categories[0]->name;
        };
      ?>
    </div>
    <div class="article-content">
      <?php the_content(); ?>
      <div class="clear"> </div>
    </div>
    <div class="author-info">
      <?php $authorID = get_the_author_meta('ID'); ?>
      <div class="author-signature">
        <img src="<?php the_field('user_signature', 'user_'.$authorID); ?>" alt="<?php echo get_the_author_meta('display_name'); ?>" class="img-responsive">
      </div>
      <div class="author-photo">
        <img src="<?php the_field('user_photo', 'user_'.$authorID); ?>" alt="<?php echo get_the_author_meta('display_name'); ?>" class="img-responsive">
      </div>
      <div class="author-name">
        <strong><?php echo get_the_author_meta('display_name'); ?></strong>
      </div>
      <?php if($authorID == '5') { ?>
        <div class="alex-coppyright">
          <em>&copy; <?php echo date('Y'); ?> Alex Evers photos. All rights reserved.</em>
        </div>
      <?php }; ?>
    </div>
    <div class="comments-box">
      <?php
          if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
        ?>
    </div>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
