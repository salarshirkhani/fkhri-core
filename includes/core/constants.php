<?php
if ( ! defined('ABSPATH') ) exit;

// Define only if not already defined in the main plugin file.
if ( ! defined('FKHRI_VERSION') ) define('FKHRI_VERSION', '1.0.0');
if ( ! defined('FKHRI_WP_DIR') ) define('FKHRI_WP_DIR', plugin_dir_path( dirname(__FILE__, 3) ));
if ( ! defined('FKHRI_WP_URL') ) define('FKHRI_WP_URL', plugin_dir_url( dirname(__FILE__, 3) ));
if ( ! defined('FKHRI_TEXTDOMAIN') ) define('FKHRI_TEXTDOMAIN', 'fkhri-core');
