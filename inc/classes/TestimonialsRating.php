<?php
namespace Rmcc;
use Timber\Timber;

class TestimonialsRating extends Timber {

  public function __construct() {
    parent::__construct();
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_filter('timber/context', array($this, 'add_to_context'));
    
    add_action('plugins_loaded', array($this, 'plugin_timber_locations'));
    add_action('plugins_loaded', array($this, 'plugin_text_domain_init')); 
    add_action('wp_enqueue_scripts', array($this, 'plugin_enqueue_assets'));

    add_filter('the_content', array($this, 'remove_autop_testimonials'), 0);
    
    add_action('init', array($this, 'register_post_types'));
    add_action('plugins_loaded' , array($this, 'plugin_custom_fields'));
    
    add_shortcode('testimonials_rating_section', 'testimonials_rating_section');
  }
  
  public function remove_autop_testimonials($content) {
    'testimonials' === get_post_type() && remove_filter( 'the_content', 'wpautop' );
    return $content;
  }
  
  public function register_post_types() {
    $labels_testimonials = array(
      'name'                  => _x( 'Testimonials', 'Testimonials label: Plural', 'testimonials-rating' ),
      'singular_name'         => _x( 'Testimonial', 'Testimonial label: Singular', 'testimonials-rating' ),
      'menu_name'             => _x( 'Testimonials', 'Testimonials label: Plural', 'testimonials-rating' ),
      'name_admin_bar'        => _x( 'Testimonial', 'Testimonial label: Singular', 'testimonials-rating' ),
      'archives'              => _x( 'Testimonials', 'Testimonials label: Archive', 'testimonials-rating' ),
      'attributes'            => 'Item Attributes',
      'parent_item_colon'     => 'Parent Item:',
      'all_items'             => 'All Items',
      'add_new_item'          => 'Add New Item',
      'add_new'               => 'Add New',
      'new_item'              => 'New Item',
      'edit_item'             => 'Edit Item',
      'update_item'           => 'Update Item',
      'view_item'             => 'View Item',
      'view_items'            => 'View Items',
      'search_items'          => 'Search Item',
      'not_found'             => 'Not found',
      'not_found_in_trash'    => 'Not found in Trash',
      'featured_image'        => 'Featured Image',
      'set_featured_image'    => 'Set featured image',
      'remove_featured_image' => 'Remove featured image',
      'use_featured_image'    => 'Use as featured image',
      'insert_into_item'      => 'Insert into item',
      'uploaded_to_this_item' => 'Uploaded to this item',
      'items_list'            => 'Items list',
      'items_list_navigation' => 'Items list navigation',
      'filter_items_list'     => 'Filter items list',
    );
    $args_testimonials = array(
      'label'                 => _x( 'Testimonials', 'Testimonials label: Plural', 'testimonials-rating' ),
      'description'           => _x( 'Competition Testimonial...', 'Testimonials description', 'testimonials-rating' ),
      'labels'                => $labels_lists,
      'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 4,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'query_var'             => false,
      'capability_type'       => 'page',
    );
    register_post_type( 'testimonials', $args_testimonials );
  }
  public function plugin_custom_fields() {
    if( function_exists('acf_add_local_field_group') ):
    
    acf_add_local_field_group(array(
    	'key' => 'group_60d37f3ba214d',
    	'title' => 'Testimonials',
    	'fields' => array(
    		array(
    			'key' => 'field_60d37f52d3310',
    			'label' => 'Testimonial Rating',
    			'name' => 'testimonial_rating',
    			'type' => 'number',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'default_value' => 5,
    			'placeholder' => '',
    			'prepend' => '',
    			'append' => '',
    			'min' => 1,
    			'max' => 5,
    			'step' => 1,
    		),
    	),
    	'location' => array(
    		array(
    			array(
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'testimonials',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => true,
    	'description' => '',
    ));
    
    endif;
  }
  
  public function plugin_timber_locations() {
    // if timber::locations is empty (another plugin hasn't already added to it), make it an array
    if(!Timber::$locations) Timber::$locations = array();
    // add a new views path to the locations array
    array_push(
      Timber::$locations, 
      TESTIMONIALS_RATING_PATH . 'views'
    );
  }
  public function plugin_text_domain_init() {
    load_plugin_textdomain('testimonials-rating', false, TESTIMONIALS_RATING_BASE. '/languages');
  }
  public function plugin_enqueue_assets() {
    wp_enqueue_style(
      'swiper-js',
      TESTIMONIALS_RATING_URL . 'public/css/swiper-bundle.min.css'
    );
    wp_enqueue_script(
      'swiper-js',
      TESTIMONIALS_RATING_URL . 'public/js/swiper-bundle.min.js',
      '',
      '1.0.0',
      true
    );
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
  }
  
  public function add_to_twig($twig) { 
    if(!class_exists('Twig_Extension_StringLoader')){
      $twig->addExtension(new \Twig_Extension_StringLoader());
    }
    return $twig;
  }
  public function add_to_context($context) {
    return $context;    
  }
}