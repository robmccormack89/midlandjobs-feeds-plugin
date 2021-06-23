<?php

function testimonials_rating_block() {
  
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
  
  Timber::render('testimonials-rating.twig', $context);
}