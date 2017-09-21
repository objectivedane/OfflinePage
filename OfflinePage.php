<?php

/*
Plugin Name: Offline Page
Plugin URI: http://todo.this.url
Description: Display your own page to users whose connection has dropped
Version: 1.0
Author: frankle
Author URI: http://todo.this.url
License: todo GPL2
*/

/**
 * Include the classes
 */
require_once __DIR__. '/class-migration.php';
require_once __DIR__ . '/class-action-utility.php';
require_once __DIR__. '/class-setting.php';

/**
 * Setup and teardown
 */
register_activation_hook( __FILE__, array( 'Migration', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Migration', 'deactivate' ) );

/**
 * Hooks
 */
add_action('init' , array( 'Action_Utility' , 'add_javascript_files' ));
add_action('admin_init', array( 'Action_Utility' , 'add_settings_field' ));
add_action('updated_option', array( 'Action_Utility', 'update_js_file' ));