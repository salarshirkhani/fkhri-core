<?php
if ( ! defined('ABSPATH') ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Fkhri_Hello_Check extends Widget_Base {
    public function get_name() { return 'fkhri-hello-check'; }
    public function get_title(){ return 'Fkhri Hello (Test)'; }
    public function get_icon() { return 'eicon-star'; }
    public function get_categories(){ return ['fkhri']; }
    public function get_keywords(){ return ['fkhri','test','hello']; }

    protected function register_controls() {
        $this->start_controls_section('sec', ['label'=>'تنظیمات']);
        $this->add_control('text', [
            'label' => 'متن تست',
            'type'  => Controls_Manager::TEXT,
            'default' => 'اگر این ویجت را می‌بینی یعنی رجیسترینگ درست است.',
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        echo '<div class="fkhri-hello" style="padding:16px;border:1px dashed #ddd;border-radius:10px">';
        echo esc_html( $s['text'] ?? '' );
        echo '</div>';
    }
}
