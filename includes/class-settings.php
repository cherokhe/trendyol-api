<?php
if (!defined('ABSPATH')) exit;

class WC_Trendyol_Settings {
    public function __construct() {
        add_action('admin_init', array($this, 'init_settings'));
    }
    
    public function init_settings() {
        register_setting('wc_trendyol_settings', 'wc_trendyol_options');
        
        add_settings_section(
            'wc_trendyol_api_section',
            __('API Ayarları', 'wc-trendyol'),
            array($this, 'api_section_callback'),
            'wc_trendyol'
        );
        
        $this->add_settings_field('api_key', __('API Anahtarı', 'wc-trendyol'), 'text');
        $this->add_settings_field('api_secret', __('API Şifresi', 'wc-trendyol'), 'password');
        $this->add_settings_field('supplier_id', __('Satıcı ID', 'wc-trendyol'), 'text');
    }
    
    private function add_settings_field($id, $title, $type) {
        add_settings_field(
            $id,
            $title,
            array($this, $type . '_field_callback'),
            'wc_trendyol',
            'wc_trendyol_api_section',
            array('label_for' => $id)
        );
    }
    
    public function text_field_callback($args) {
        $options = get_option('wc_trendyol_options');
        echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="wc_trendyol_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($options[$args['label_for']] ?? '') . '" class="regular-text">';
    }
    
    public function password_field_callback($args) {
        $options = get_option('wc_trendyol_options');
        echo '<input type="password" id="' . esc_attr($args['label_for']) . '" name="wc_trendyol_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($options[$args['label_for']] ?? '') . '" class="regular-text">';
    }
    
    public function api_section_callback() {
        echo '<p>' . esc_html__('Trendyol API bilgilerinizi girin', 'wc-trendyol') . '</p>';
    }
}