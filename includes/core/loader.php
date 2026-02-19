<?php
if ( ! defined('ABSPATH') ) exit;

// Load constants first
require_once FKHRI_WP_DIR . 'includes/core/constants.php';

// 1) Elementor widgets (only if Elementor is loaded)
require_once FKHRI_WP_DIR . 'includes/elementor/elementor.php';

// 2) Post types + metaboxes
require_once FKHRI_WP_DIR . 'includes/content/content.php';

// 3) Snippets (future)
require_once FKHRI_WP_DIR . 'includes/snippets/snippets.php';

// 4) Admin panel (future)
require_once FKHRI_WP_DIR . 'includes/admin/admin.php';
