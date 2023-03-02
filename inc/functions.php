<?php

function midlandjob_feeds($atts) {
  $context = Timber::context();

  $template = 'feed.twig';

  // $feed_url = 'https://midlandjobs.ie/feeds/standard.xml'; // default feed url
  $feed_url = '';

  if(is_array($atts)){
    if(array_key_exists('url', $atts)){
      $feed_url = $atts['url']; // set new feed url if exists in the shortcode
    }
  }

  $feed = new Rmcc\MidlandjobsFeed($feed_url); // new Feed object from string 
  $context['feed'] = $feed;

  if(is_array($atts)){
    if(in_array('disable_header', $atts)) $context['feed']->disable_header = true;
    if(in_array('disable_modals', $atts)) $context['feed']->disable_modals = true;
    if(in_array('carousel', $atts) || array_key_exists('carousel', $atts)) $template = 'feed-carousel.twig';
  }

  $context['q'] = '';
  
  if(!isset($_SESSION["q"])){
    $_SESSION["q"] = 1 ;
  } else {
    $_SESSION["q"]++ ;
  }
  $context['q'] = $_SESSION["q"];

  $out = Timber::compile($template, $context);
  return $out;
}