<?php
//ENABLE MENUS AND RSS FEEDS
if ( function_exists( 'add_theme_support' ) ):
  add_theme_support( 'menus' );
  add_theme_support( 'automatic-feed-links' );
endif;

// ENABLE SIDEBARS
if ( function_exists('register_sidebars') ):
  register_sidebar(array(
    'name'          => 'Main Sidebar',
    'id'            => 'main-sidebar-widgets',
	  'description'   => '',
    'class'         => '',
	  'before_widget' => '<li>',
	  'after_widget'  => '</li>',
	  'before_title'  => '<div class="sidebar-widget-title">',
	  'after_title'   => '</div>'
  ));
endif;

// ENABLE BOOTSTRAP NAVIGATION MENU
require_once('bootstrap_navwalker.php');

//ENABLE EDITOR STYLES
add_editor_style('editor-style.css');

// REMOVE WORDPRESS VERSION META TAG
function remove_wp_version() {
	return '';
}
add_filter('the_generator', 'remove_wp_version');

// ENABLE FEATURED IMAGES FOR POSTS
add_theme_support('post-thumbnails');
set_post_thumbnail_size(1200, 630, true); //Large Facebook Image
set_post_thumbnail_size(600, 315, true);  //Small Facebook Image

// GET EXCERPT OUTSIDE OF WP LOOP
function get_excerpt_by_id($post_id){
  $the_post = get_post($post_id);
  $the_excerpt = $the_post->post_content;
  $excerpt_length = 35; //Excerpt length word count
  $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
  $words = explode(' ', $the_excerpt, $excerpt_length + 1);
  if(count($words) > $excerpt_length) :
    array_pop($words);
    array_push($words, '…');
    $the_excerpt = implode(' ', $words);
  endif;
  $the_excerpt = '' . $the_excerpt . '';
  return $the_excerpt;
};

//LOAD/MODIFY COMMENTS
add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );
function bootstrap3_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();

    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

    $fields   =  array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
    );

    return $fields;
};
add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );
function bootstrap3_comment_form( $args ) {
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
    return $args;
};
add_action('comment_form', 'bootstrap3_comment_button' );
function bootstrap3_comment_button() {
    echo '<button class="btn btn-default" type="submit">' . __( 'Submit' ) . '</button>';
};
function wpbootstrap_scripts() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts' );

//Wrap Article ifames to make them Responsive
function wrap_video_embed_with_div($html, $url, $attr) {
  return '<div class="videowrapper">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'wrap_video_embed_with_div', 10, 3);

//Limit Excerpt By Word Count
function limit_excerpt_words($string, $word_limit) {
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

//Enable jQuery
function theme_scripts() {
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'theme_scripts');
?>
