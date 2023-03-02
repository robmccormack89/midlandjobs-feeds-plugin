<?php
namespace Rmcc;

use Timber\Timber;

class MidlandJobsFeedsPlugin extends Timber
{

  public function __construct()
  {
    parent::__construct();
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_filter('timber/context', array($this, 'add_to_context'));

    add_action('plugins_loaded', array($this, 'plugin_timber_locations'));
    add_action('plugins_loaded', array($this, 'plugin_text_domain_init'));
    add_action('wp_enqueue_scripts', array($this, 'plugin_enqueue_assets'));

    // add_filter('the_content', array($this, 'remove_autop_testimonials'), 0);
    // add_action('init', array($this, 'register_post_types'));
    // add_action('plugins_loaded', array($this, 'plugin_custom_fields'));
    // add_shortcode('testimonials_rating_section', 'testimonials_rating_section');

    add_shortcode('midlandjob_feeds', 'midlandjob_feeds');
  }

  public function remove_autop_testimonials($content)
  {
    'testimonials' === get_post_type() && remove_filter('the_content', 'wpautop');
    return $content;
  }
  public function register_post_types()
  {
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
      MIDLANDJOBS_FEEDS_PATH . 'views'
    );
  }
  public function plugin_text_domain_init()
  {
    load_plugin_textdomain('midlandjobs-feeds', false, MIDLANDJOBS_FEEDS_BASE . '/languages');
  }
  public function plugin_enqueue_assets()
  {
    wp_enqueue_style(
      'midlandjobs-feeds',
      MIDLANDJOBS_FEEDS_URL . 'public/css/midlandjobs-feeds.css',
      array('swiper-js')
    );
    wp_enqueue_script(
      'midlandjobs-feeds',
      MIDLANDJOBS_FEEDS_URL . 'public/js/midlandjobs-feeds.js',
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