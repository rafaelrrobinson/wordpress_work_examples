  </div>
</div>
<div id="footer">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
        $defaults = array(
	      'theme_location'  => '',
	      'menu'            => 'Footer Navigation',
	      'container'       => false,
	      'container_class' => false,
	      'container_id'    => false,
	      'menu_class'      => 'list-inline',
	      'menu_id'         => 'footer-navigation',
	      'echo'            => true,
	      'fallback_cb'     => 'wp_page_menu',
	      'before'          => '',
	      'after'           => '',
	      'link_before'     => '',
	      'link_after'      => '',
	      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	      'depth'           => 0,
	      'walker'          => new wp_bootstrap_navwalker()
        );
        wp_nav_menu($defaults);
        ?>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="<?php echo get_template_directory_uri(); ?>/javascript/hoverintent.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/javascript/js.cookie.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/javascript/html5lightbox/html5lightbox.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/javascript/functions.js"></script>
<?php wp_footer(); ?>
</body>
</html>
