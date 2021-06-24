<?php

function testimonials_rating_section() {
  
  // if timber::locations is empty (another plugin hasn't already added to it), make it an array
  if(!Timber::$locations) Timber::$locations = array();

  // add a new views path to the locations array
  array_push(
    Timber::$locations, 
    TESTIMONIALS_RATING_PATH . 'views'
  );
  
  $context = Timber::context();
  
  // testimonials args
  $args = array(
   'post_type'             => 'testimonials',
   'post_status'           => 'publish',
   'posts_per_page'        => '6',
  );
  $context['testimonials'] = new Timber\PostQuery($args);
  
  $out = Timber::compile('testimonials-rating.twig', $context);
  return $out;
}