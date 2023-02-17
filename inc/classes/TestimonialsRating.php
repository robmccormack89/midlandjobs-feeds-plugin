<?php
namespace Rmcc;

use Timber\Timber;

class TestimonialsRating extends Timber
{

  public function __construct()
  {
    parent::__construct();
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_filter('timber/context', array($this, 'add_to_context'));

    add_action('plugins_loaded', array($this, 'plugin_timber_locations'));
    add_action('plugins_loaded', array($this, 'plugin_text_domain_init'));
    add_action('wp_enqueue_scripts', array($this, 'plugin_enqueue_assets'));

    add_filter('the_content', array($this, 'remove_autop_testimonials'), 0);

    add_action('init', array($this, 'register_post_types'));
    // add_action('plugins_loaded', array($this, 'plugin_custom_fields'));

    add_shortcode('testimonials_rating_section', 'testimonials_rating_section');
  }

  public function remove_autop_testimonials($content)
  {
    'testimonials' === get_post_type() && remove_filter('the_content', 'wpautop');
    return $content;
  }

  public function register_post_types()
  {
    $labels_testimonials = array(
      'name' => _x('Testimonials', 'Post Type General Name', 'testimonials-rating'),
      'singular_name' => _x('Testimonial', 'Post Type Singular Name', 'testimonials-rating'),
      'menu_name' => __('Testimonials', 'testimonials-rating'),
      'name_admin_bar' => __('Testimonial', 'testimonials-rating'),
      'archives' => __('Item Archives', 'testimonials-rating'),
      'attributes' => __('Item Attributes', 'testimonials-rating'),
      'parent_item_colon' => __('Parent Item:', 'testimonials-rating'),
      'all_items' => __('All Items', 'testimonials-rating'),
      'add_new_item' => __('Add New Item', 'testimonials-rating'),
      'add_new' => __('Add New', 'testimonials-rating'),
      'new_item' => __('New Item', 'testimonials-rating'),
      'edit_item' => __('Edit Item', 'testimonials-rating'),
      'update_item' => __('Update Item', 'testimonials-rating'),
      'view_item' => __('View Item', 'testimonials-rating'),
      'view_items' => __('View Items', 'testimonials-rating'),
      'search_items' => __('Search Item', 'testimonials-rating'),
      'not_found' => __('Not found', 'testimonials-rating'),
      'not_found_in_trash' => __('Not found in Trash', 'testimonials-rating'),
      'featured_image' => __('Featured Image', 'testimonials-rating'),
      'set_featured_image' => __('Set featured image', 'testimonials-rating'),
      'remove_featured_image' => __('Remove featured image', 'testimonials-rating'),
      'use_featured_image' => __('Use as featured image', 'testimonials-rating'),
      'insert_into_item' => __('Insert into item', 'testimonials-rating'),
      'uploaded_to_this_item' => __('Uploaded to this item', 'testimonials-rating'),
      'items_list' => __('Items list', 'testimonials-rating'),
      'items_list_navigation' => __('Items list navigation', 'testimonials-rating'),
      'filter_items_list' => __('Filter items list', 'testimonials-rating'),
    );
    $args_testimonials = array(
      'label' => __('Testimonial', 'testimonials-rating'),
      'description' => __('Testimonial Description', 'testimonials-rating'),
      'labels' => $labels_testimonials,
      'supports' => array('title', 'editor', 'revisions', 'custom-fields'),
      'hierarchical' => false,
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 4,
      'show_in_admin_bar' => true,
      'show_in_nav_menus' => true,
      'can_export' => true,
      'has_archive' => false,
      'exclude_from_search' => true,
      'publicly_queryable' => true,
      'query_var' => false,
      'capability_type' => 'page',
    );
    register_post_type('testimonials', $args_testimonials);
  }
  public function plugin_custom_fields()
  {

  }

  public function plugin_timber_locations()
  {
    // if timber::locations is empty (another plugin hasn't already added to it), make it an array
    if (!Timber::$locations)
      Timber::$locations = array();
    // add a new views path to the locations array
    array_push(
      Timber::$locations,
      TESTIMONIALS_RATING_PATH . 'views'
    );
  }
  public function plugin_text_domain_init()
  {
    load_plugin_textdomain('testimonials-rating', false, TESTIMONIALS_RATING_BASE . '/languages');
  }
  public function plugin_enqueue_assets()
  {
    wp_enqueue_style(
      'testimonials-rating',
      TESTIMONIALS_RATING_URL . 'public/css/testimonials-rating.css',
      array('swiper-js')
    );
    wp_enqueue_script(
      'testimonials-rating',
      TESTIMONIALS_RATING_URL . 'public/js/testimonials-rating.js',
      array('jquery', 'swiper-js'),
      '1.0.0',
      true
    );
    wp_enqueue_style(
      'swiper',
      'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'
    );
    wp_enqueue_script(
      'swiper',
      'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
      '',
      '8.0.0',
      false
    );
    wp_enqueue_style(
      'uikit',
      'https://cdn.jsdelivr.net/npm/uikit@3.15.24/dist/css/uikit.min.css'
    );
    wp_enqueue_script(
      'uikit',
      'https://cdn.jsdelivr.net/npm/uikit@3.15.24/dist/js/uikit.min.js',
      array(),
      '3.15.24',
      false
    );
    wp_enqueue_script(
      'uikit-icons',
      'https://cdn.jsdelivr.net/npm/uikit@3.15.24/dist/js/uikit-icons.min.js',
      array(),
      '3.15.24',
      false
    );
  }

  public function add_to_twig($twig)
  {
    if (!class_exists('Twig_Extension_StringLoader')) {
      $twig->addExtension(new \Twig_Extension_StringLoader());
    }
    return $twig;
  }
  public function add_to_context($context)
  {
    return $context;
  }
  
}