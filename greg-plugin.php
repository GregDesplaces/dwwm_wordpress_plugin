<?php
/**
 * Plugin Name: Greg Plugin
 * Description: Un plugin pour apprendre à créer des plugins
 * Version: 1.0
 * Author: Greg
 * Author URI: http://www.gregdesplaces.com/
 * License: GPL2
 * Text Domain: greg-plugin
 * Domain Path: /languages/
 */


/**
 * If this file is called directly, abort.
 */
defined('ABSPATH') or die('Nothing to see here.');

/**
 * Initialize the plugin by creating an instance of the class.
 *
 * @returns void
 * @since 1.0
 */
add_action( 'plugins_loaded', function() {
    require_once plugin_dir_path( __FILE__ ) . 'inc/greg-plugin-class.php';
    if (class_exists('GregPlugin')) {
        new GregPlugin();
    }
} );



