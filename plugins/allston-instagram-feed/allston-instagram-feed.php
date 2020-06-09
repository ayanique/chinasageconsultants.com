<?php
/*
Plugin Name: Allston Instagram Feed
Description: Plugin that adds Instagram feed functionality to our theme
Author: Elated Themes
Version: 1.0.1
*/
define('ALLSTON_INSTAGRAM_FEED_VERSION', '1.0.1');
define('ALLSTON_INSTAGRAM_ABS_PATH', dirname(__FILE__));
define('ALLSTON_INSTAGRAM_REL_PATH', dirname(plugin_basename(__FILE__ )));

include_once 'load.php';

if(!function_exists('allston_instagram_feed_text_domain')) {
    /**
     * Loads plugin text domain so it can be used in translation
     */
    function allston_instagram_feed_text_domain() {
        load_plugin_textdomain('allston-instagram-feed', false, ALLSTON_INSTAGRAM_REL_PATH.'/languages');
    }

    add_action('plugins_loaded', 'allston_instagram_feed_text_domain');
}