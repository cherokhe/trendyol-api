<?php
defined('ABSPATH') || exit;

class WC_Trendyol_Product_Mapping {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_product_mapping_menu'], 25);
        add_action('add_meta_boxes', [$this, 'add_product_meta_box']);
        add_action('save_post_product', [$this, 'save_product_mapping'], 10, 2);
        add_action('wp_ajax_wc_trendyol_sync_single_product', [$this, 'sync_single_product']);
    }

    public function add_product_mapping_menu() {
        add_submenu_page(
            'woocommerce',
            __('Ürün Eşleştirme', 'wc-trendyol'),
            __('Ürün Eşleştirme', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol-product-mapping',
            [$this, 'render_product_mapping_page']
        );
    }

    public function add_product_meta_box() {
        add_meta_box(
            'wc_trendyol_product_mapping',
            __('Trendyol Entegrasyonu', 'wc-trendyol'),
            [$this, 'render_product_meta_box'],
            'product',
            'side',
            'high'
        );
    }

    public function render_product_mapping_page() {
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/product-mapping.php';
    }

    public function render_product_meta_box($post) {
        $trendyol_id = get_post_meta($post->ID, '_trendyol_id', true);
        $trendyol_category = get_post_meta($post->ID, '_trendyol_category', true);
        $trendyol_categories = WC_Trendyol_API::get_categories();
        
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/product-meta-box.php';
    }

    public function save_product_mapping($post_id, $post) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_product', $post_id)) return;
        if (isset($_POST['_trendyol_category'])) {
            update_post_meta($post_id, '_trendyol_category', sanitize_text_field($_POST['_trendyol_category']));
        }
    }

    public function sync_single_product() {
        check_ajax_referer('wc-trendyol-sync', 'security');
        
        if (!current_user_can('manage_woocommerce')) {
            wp_send_json_error(__('Yetkiniz yok!', 'wc-trendyol'));
        }

        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $product = wc_get_product($product_id);

        if (!$product) {
            wp_send_json_error(__('Ürün bulunamadı!', 'wc-trendyol'));
        }

        $result = WC_Trendyol_Product_Sync::sync_product($product);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        wp_send_json_success(__('Ürün başarıyla senkronize edildi!', 'wc-trendyol'));
    }
}