<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * init.php (Plugin bootstrap)
 * - Loads textdomain on 'init'
 * - Includes CPT (stories)
 * - Registers Swiper + plugin assets (CSS/JS)
 * - Adds Elementor category 'fkhri'
 * - Registers widgets from /includes/elementor/widgets
 * - Includes Ajax handlers
 *
 */

# -------------------------------------------------
# 0) Resolve base DIR/URL (plugin root)
# -------------------------------------------------
$FKHRI_BASE_DIR = plugin_dir_path( dirname(__FILE__) ); // /plugin-root/
$FKHRI_BASE_URL = plugin_dir_url(  dirname(__FILE__) ); // /plugin-root/ URL

# Optional constants (only if not defined elsewhere)
if ( ! defined('FKHRI_WP_DIR') ) define('FKHRI_WP_DIR', $FKHRI_BASE_DIR);
if ( ! defined('FKHRI_WP_URL') ) define('FKHRI_WP_URL', $FKHRI_BASE_URL);

# -------------------------------------------------
# 0.1) Textdomain (avoid JIT notice)
# -------------------------------------------------
add_action('init', function(){
    load_plugin_textdomain(
        FKHRI_TEXTDOMAIN,
        false,
        dirname( plugin_basename( FKHRI_WP_DIR . 'fkhri-core.php' ) ) . '/languages'
    );
});

# -------------------------------------------------
# 0.6) Ajax handlers
# -------------------------------------------------
$ajax_file = FKHRI_WP_DIR . 'includes/ajax/ajax-search.php';
if ( file_exists($ajax_file) ) {
    require_once $ajax_file;
}

# -------------------------------------------------
# 1) Assets (front): Swiper + plugin assets
# -------------------------------------------------
add_action('wp_enqueue_scripts', function(){

    // Swiper (register if missing)
    $swiper_ver = '8.4.5';
    if ( ! wp_style_is('swiper', 'registered') ) {
        wp_register_style ('swiper', "https://cdn.jsdelivr.net/npm/swiper@{$swiper_ver}/swiper-bundle.min.css", [], $swiper_ver);
    }
    if ( ! wp_script_is('swiper', 'registered') ) {
        wp_register_script('swiper', "https://cdn.jsdelivr.net/npm/swiper@{$swiper_ver}/swiper-bundle.min.js", [], $swiper_ver, true);
    }

    // CSS/JS directories
    $css_dir = FKHRI_WP_DIR . 'assets/css/';
    $js_dir  = FKHRI_WP_DIR . 'assets/js/';

    // Helper to register by file name
    $reg_css = function($handle, $file, $deps = []) use ($css_dir){
        $abs = $css_dir . $file;
        if ( file_exists($abs) ) {
            wp_register_style($handle, FKHRI_WP_URL . 'assets/css/' . $file, $deps, filemtime($abs));
        }
    };
    $reg_js = function($handle, $file, $deps = []) use ($js_dir){
        $abs = $js_dir . $file;
        if ( file_exists($abs) ) {
            wp_register_script($handle, FKHRI_WP_URL . 'assets/js/' . $file, $deps, filemtime($abs), true);
        }
    };

    // Stories (اینستاگرامی)
    $reg_css('fkhri-story', 'story.css', ['swiper']);
    $reg_js ('fkhri-story', 'story.js',  ['jquery']);

    // Read More (نمونه قدیمی)
    $reg_css('fkhri-readmore',   'read-more.css');
    $reg_js ('fkhri-readmore','read-more.js', ['jquery']);

    // Breadcrumb
    $reg_css('fkhri-breadcrumb', 'breadcrumb.css');

    // Product Carousel
    $reg_css('fkhri-product-carousel',    'product-carousel.css', ['swiper']);
    $reg_js ('fkhri-product-carousel-js', 'product-carousel.js',  ['jquery','elementor-frontend','swiper']);

    // Tabbed Product Carousel
    $reg_css('fkhri-tabbed-carousel',     'tabbed-carousel.css', ['swiper']);
    $reg_js ('fkhri-tabbed-carousel-js',  'tabbed-carousel.js',  ['jquery','elementor-frontend','swiper']);

    // Ajax Search
    $reg_css('fkhri-ajax-search', 'ajax-search.css');
    $reg_js ('fkhri-ajax-search', 'ajax-search.js', ['jquery']);

    // Ticker Carousel (جدید)
    $reg_css('fkhri-ticker-carousel', 'ticker-carousel.css');
    $reg_js ('fkhri-ticker-carousel', 'ticker-carousel.js', ['jquery']);
    
    // Counter
    $reg_css('fkhri-counter', 'counter.css');
    $reg_js ('fkhri-counter', 'counter.js', ['jquery']);

    // pricing
    $reg_css('fkhri-pricing', 'pricing.css');
    $reg_js ('fkhri-pricing', 'pricing.js', ['jquery']);

    // faq-accordion
    $reg_css('fkhri-faq-accordion', 'faq-accordion.css');
    $reg_js ('fkhri-faq-accordion', 'faq-accordion.js', ['jquery']);
    
    // testimonials
    $reg_css('fkhri-testimonials', 'testimonials.css');
    $reg_js ('fkhri-testimonials', 'testimonials.js', ['jquery']);
});

# -------------------------------------------------
# 2) Elementor: add category
# -------------------------------------------------
add_action('elementor/elements/categories_registered', function($elements_manager){
    $elements_manager->add_category('fkhri', [
        'title' => 'Fakhraei',
        'icon'  => 'fa fa-plug'
    ]);
});

# -------------------------------------------------
# 3) Elementor: register widgets
# -------------------------------------------------
add_action('elementor/widgets/register', function($widgets_manager){

    $widgets_dir = FKHRI_WP_DIR . 'includes/widgets/';

    // فایل‌ها را هر کدام اگر وجود داشتند لود کن
    $files = [
        'class-fkhri-read-more.php',
        'class-fkhri-breadcrumb.php',
        'class-fkhri-product-carousel.php',
        'class-fkhri-tabbed-product-carousel.php',
        'class-stories.php',                
        'class-ajax-search.php',             // Ajax Search
        'class-fkhri-ticker-carousel.php', // Ticker Carousel 
        'class-fkhri-counter.php',
        'class-fkhri-pricing.php',
        'class-fkhri-faq-accordion.php',
        'class-fkhri-testimonials.php',
    ];

    foreach ($files as $file) {
        $path = $widgets_dir . $file;
        if ( file_exists($path) ) require_once $path;
    }

    // ثبت کلاس‌ها اگر موجودند
    if ( class_exists('\Fakhraei_Read_More') ) {
        $widgets_manager->register( new \Fakhraei_Read_More() );
    }
    if ( class_exists('\Fakhraei_Breadcrumb') ) {
        $widgets_manager->register( new \Fakhraei_Breadcrumb() );
    }
    if ( class_exists('\Fakhraei_Product_Carousel') ) {
        $widgets_manager->register( new \Fakhraei_Product_Carousel() );
    }
    if ( class_exists('\Fakhraei_Tabbed_Product_Carousel') ) {
        $widgets_manager->register( new \Fakhraei_Tabbed_Product_Carousel() );
    }
    if ( class_exists('\Fakhraei_Ajax_Search') ) {
        $widgets_manager->register( new \Fakhraei_Ajax_Search() );
    }
    if ( class_exists('\Fakhraei_Ticker_Carousel') ) {
        $widgets_manager->register( new \Fakhraei_Ticker_Carousel() );
    }
    if ( class_exists('\Fakhraei_Counter') ) {
        $widgets_manager->register( new \Fakhraei_Counter() );
    }
    if ( class_exists('\Fakhraei_Pricing') ) {
        $widgets_manager->register( new \Fakhraei_Pricing() );
    }
    if ( class_exists('\Fakhraei_Pricing') ) {
        $widgets_manager->register( new \Fakhraei_FAQ_Accordion() );
    }
    if ( class_exists('\Fakhraei_Testimonials') ) {
        $widgets_manager->register( new \Fakhraei_Testimonials() );
    }
});

add_action('wp_head', function(){
  if ( empty($GLOBALS['shpd_testimonials_paging']) ) return;
  $p = $GLOBALS['shpd_testimonials_paging'];
  if (!empty($p['prev'])) echo '<link rel="prev" href="'.esc_url($p['prev']).'">'."\n";
  if (!empty($p['next'])) echo '<link rel="next" href="'.esc_url($p['next']).'">'."\n";
}, 1);

