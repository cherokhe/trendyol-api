<?php
defined('ABSPATH') || exit;

class WC_Trendyol_Category_Mapping {
    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_menu']);
        add_action('wp_ajax_wc_trendyol_save_mappings', [__CLASS__, 'save_mappings']);
    }
    
    public static function add_menu() {
        add_submenu_page(
            'woocommerce',
            'Trendyol Kategori Eşleştirme',
            'Trendyol Kategoriler',
            'manage_woocommerce',
            'wc-trendyol-categories',
            [__CLASS__, 'render_page']
        );
    }
    
    public static function render_page() {
        $wc_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
        $ty_cats = WC_Trendyol_API::get_categories();
        $mappings = get_option('wc_trendyol_category_mappings', []);
        
        include WC_TRENDYOL_PATH . 'templates/admin/category-mapping.php';
    }
    
    public static function get_mapped_category($wc_cat_id) {
        $mappings = get_option('wc_trendyol_category_mappings', []);
        return $mappings[$wc_cat_id] ?? 0;
    }
    
    public static function save_mappings() {
        check_ajax_referer('wc_trendyol_mappings', 'security');
        
        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error('Yetkiniz yok');
        }
        
        $mappings = isset($_POST['mappings']) ? array_map('intval', $_POST['mappings']) : [];
        update_option('wc_trendyol_category_mappings', $mappings);
        
        wp_send_json_success('Eşleştirmeler kaydedildi');
    }
}