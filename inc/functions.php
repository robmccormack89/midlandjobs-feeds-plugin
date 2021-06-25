<?php

function testimonials_rating_section() {
  
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