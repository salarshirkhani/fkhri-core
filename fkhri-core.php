<?php
/**
 * Plugin Name: Fakhraei Core
 * Description: elementor widgets pack
 * Version: 1.0.0
 * Author: Salar Shirkhani
 * Text Domain: fkhri-core
 */

if ( ! defined('ABSPATH') ) exit;

// ROUTES
if ( ! defined('FKHRI_WP_DIR') ) define('FKHRI_WP_DIR', plugin_dir_path(__FILE__));
if ( ! defined('FKHRI_WP_URL') ) define('FKHRI_WP_URL', plugin_dir_url(__FILE__));
if ( ! defined('FKHRI_VERSION') ) define('FKHRI_VERSION', '1.0.0');
if ( ! defined('FKHRI_TEXTDOMAIN') ) define('FKHRI_TEXTDOMAIN', 'fkhri-core');

require_once FKHRI_WP_DIR . 'includes/core/loader.php';
