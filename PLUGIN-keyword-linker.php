<?php
/**
* Plugin Name: Keyword Link Tool
* Plugin URI:
* Description: Allow staff to target specific keywords in content to auto link.
* Version: 0.1
* Author: Rafael Robinson
* Author URI: https://www.rafaelrobinson.com/
*/

// FUNCTIONS TO RUN PLUGIN
add_action('admin_menu', 'auto_keyword_linker');
function auto_keyword_linker() {
  $page_title = 'Auto Keyword Linker';
  $menu_title = 'Keyword Linker';
  $capability = 'edit_posts';
  $menu_slug = 'keyword_menu';
  $function = 'keyword_display';
  $icon_url = '';
  $position = 99;

  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

function keyword_admin_styles() {
  wp_enqueue_style('keyword-list-styles', plugin_dir_url( __FILE__ ) . 'includes/css/styles.css');
}
add_action('admin_print_styles', 'keyword_admin_styles');

// Build Page. Cache It. Update Keywords. Display.
function auto_keyword_replace($where) {
  $bad_apostrophes = array('&#8217;', '’', '&#8216;', '‘');
  $good_apostrophes = array('\'', '\'', '\'', '\'');
  $where = str_replace($bad_apostrophes, $good_apostrophes, $where);

  $keyword_keywords_to_replace = get_option('keyword_keywords_to_replace');
  $keyword_keyword_links = get_option('keyword_keyword_links');
  $KWs = explode("\n", $keyword_keywords_to_replace);
  $URLs = explode("\n", $keyword_keyword_links);

  $pattern = array();
  $replacement = array();
  for($i=0; $i< count($KWs); $i++) {
    $pattern2 = '#<a[^>]*>'.trim($KWs[$i]).'</a>#';
    $pattern3 = '#<div id="elite_options"[^>]*>(.*?)</div>#s';
    $pattern4 = '/\.(jpg|png|jpeg|gif)$/';
    $pattern5 = '#<div class="sub-topnews-featured"[^>]*>(.*?)</div>#s';
    $pattern6 = '#<div class="top-news-list"[^>]*>(.*?)</div>#s';
    $pattern7 = '#<h1[^>]*>(.*?)</h1>#s';
    $pattern8 = '#<div class="archive-post"[^>]*>(.*?)</div>#s';
    $pattern9 = '#<div class="video-title"[^>]*>(.*?)</div>#s';
    $pattern10 = '#<div class="sla-ad"[^>]*>(.*?)</div>#s';
    $pattern11 = '#<div class="Elite_video_player"[^>]*>(.*?)</div>#s';
    if(
      preg_match($pattern2, $where) ||
      preg_match($pattern3, $where) ||
      preg_match($pattern4, $where) ||
      preg_match($pattern5, $where) ||
      preg_match($pattern6, $where) ||
      preg_match($pattern7, $where) ||
      preg_match($pattern8, $where) ||
      preg_match($pattern9, $where) ||
      preg_match($pattern10, $where) ||
      preg_match($pattern11, $where)
    )  {
      continue;
    } else {
      if ( ! isset($pattern[$i])) {
        $pattern[$i] = null;
      };

      $pattern[$i] ='#\\b'.trim($KWs[$i]).'\\b#';

      if ( ! isset($replacement[$i])) {
        $replacement[$i] = null;
      };
      $replacement[$i] .= '<a href="'.$URLs[$i].'" class="horse-link" target="_blank">'.rtrim(stripslashes($KWs[$i])).'</a>';
    }
  }

  return preg_replace($pattern, $replacement, $where);

};
add_filter('get_the_excerpt','auto_keyword_replace');
add_filter('the_content','auto_keyword_replace');

function auto_non_traditional_content() {
  if( !is_single() || !is_archive() || !is_category() || !is_front_page() || !is_page('europe') ) {
    if( !is_page(array('sales-results-by-stallion', 'black-type-library', 'rising-stars', 'rising-stars-eu', 'entries')) ) {
      function buffer_start() {
        ob_start("auto_keyword_replace");
      };
      function buffer_end() {
        ob_end_flush();
      };
      add_action('wp_head', 'buffer_start');
      add_action('wp_footer', 'buffer_end');
    }
  }
}
add_action( 'wp_enqueue_scripts', 'auto_non_traditional_content' );

// SHOW ADMIN PAGE
function keyword_display() {
  if (isset($_POST['keyword_keywords_to_replace'])) {
    update_option('keyword_keywords_to_replace', $_POST['keyword_keywords_to_replace']);
    $keyword_keywords_to_replace = $_POST['keyword_keywords_to_replace'];
  }
  if (isset($_POST['keyword_keyword_links'])) {
    update_option('keyword_keyword_links', $_POST['keyword_keyword_links']);
    $keyword_keyword_links = $_POST['keyword_keyword_links'];
  }
  $keyword_keywords_to_replace = get_option('keyword_keywords_to_replace', '');
  $keyword_keyword_links = get_option('keyword_keyword_links', '');
  include 'keyword-page.php';
}

// SHOW BUTTON ON WP EDITOR
function enqueue_plugin_scripts($plugin_array) {
    $plugin_array["auto_button_plugin"] =  plugin_dir_url(__FILE__) . "includes/js/functions.js";
    return $plugin_array;
}
add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons) {
    array_push($buttons, "auto");
    return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");
