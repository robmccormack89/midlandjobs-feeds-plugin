<?php
/*
Plugin Name: Midlandjobs RSS/XML Feeds for Smartjobboard by RMcC
Plugin URI: https://github.com/robmccormack89/midlandjobs-feeds-plugin
Description: Add some feeds to your site using the [midlandjob_feeds] shortcode.....
Version: 1.0.0
Author: robmccormack89
Author URI: https://github.com/robmccormack89
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: LICENSE
Text Domain: midlandjobs-feeds
Domain Path: /languages/
*/

// don't run if someone access this file directly
defined('ABSPATH') || exit;

// define some constants
if (!defined('MIDLANDJOBS_FEEDS_PATH')) define('MIDLANDJOBS_FEEDS_PATH', plugin_dir_path( __FILE__ ));
if (!defined('MIDLANDJOBS_FEEDS_URL')) define('MIDLANDJOBS_FEEDS_URL', plugin_dir_url( __FILE__ ));
if (!defined('MIDLANDJOBS_FEEDS_BASE')) define('MIDLANDJOBS_FEEDS_BASE', dirname(plugin_basename( __FILE__ )));

/* plugin activation 

  using tgm-plugin-activation

*/
require_once MIDLANDJOBS_FEEDS_PATH . '/inc/lib/plugin-activation.php';

// require the composer autoloader
if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

// then require the main plugin class. this class extends Timber/Timber which is required via composer
new Rmcc\MidlandJobsFeedsPlugin;

// require action functions 
require_once('inc/functions.php');