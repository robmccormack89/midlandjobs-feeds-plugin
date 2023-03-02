<?php

/* stuff to say we need timber activated!! see TGM Plugin activation library for php 

  register the required plugins (ACF, Loco Translate)

*/

require_once MIDLANDJOBS_FEEDS_PATH . '/inc/lib/class-tgm-plugin-activation.php';
add_action('tgmpa_register', function(){
  $plugins = array(
    // loco translate
    array(
      'name' => 'Loco Translate',
			'slug' => 'loco-translate',
			'required' => false
		),
	);
	$config  = array(
		'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu' => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug' => 'themes.php', // Parent menu slug.
		'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices' => true, // Show admin notices or not.
		'dismissable' => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message' => '' // Message to output right before the plugins table.
	);
	tgmpa($plugins, $config);
});