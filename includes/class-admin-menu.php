<?php
defined('ABSPATH') || exit;

class WC_Trendyol_Admin_Menu {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_menu_items'], 25);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function add_menu_items() {
        add_menu_page(
            __('Trendyol Entegrasyon', 'wc-trendyol'),
            __('Trendyol Entegrasyon', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol',
            [$this, 'render_dashboard'],
            'dashicons-networking',
            56
        );

        add_submenu_page(
            'wc-trendyol',
            __('Dashboard', 'wc-trendyol'),
            __('Dashboard', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol',
            [$this, 'render_dashboard']
        );

        add_submenu_page(
            'wc-trendyol',
            __('Ürün Eşleştirme', 'wc-trendyol'),
            __('Ürün Eşleştirme', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol-product-mapping',
            [$this, 'render_product_mapping']
        );

        add_submenu_page(
            'wc-trendyol',
            __('Kategori Eşleştirme', 'wc-trendyol'),
            __('Kategori Eşleştirme', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol-category-mapping',
            [$this, 'render_category_mapping']
        );

        add_submenu_page(
            'wc-trendyol',
            __('Ayarlar', 'wc-trendyol'),
            __('Ayarlar', 'wc-trendyol'),
            'manage_woocommerce',
            'wc-trendyol-settings',
            [$this, 'render_settings']
        );
    }

    public function render_dashboard() {
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/dashboard.php';
    }

    public function render_product_mapping() {
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/product-mapping.php';
    }

    public function render_category_mapping() {
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/category-mapping.php';
    }

    public function render_settings() {
        include WC_TRENDYOL_PLUGIN_PATH . 'templates/admin/settings.php';
    }

    public function enqueue_assets($hook) {
        if (strpos($hook, 'wc-trendyol') !== false) {
            wp_enqueue_style(
                'wc-trendyol-admin',
                WC_TRENDYOL_ASSETS_URL . 'css/admin.css',
                [],
                filemtime(WC_TRENDYOL_PLUGIN_PATH . 'assets/css/admin.css')
            );

            wp_enqueue_script(
                'wc-trendyol-admin',
                WC_TRENDYOL_ASSETS_URL . 'js/admin.js',
                ['jquery', 'select2'],
                filemtime(WC_TRENDYOL_PLUGIN_PATH . 'assets/js/admin.js'),
                true
            );

            wp_localize_script('wc-trendyol-admin', 'wcTrendyol', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wc-trendyol-nonce'),
                'i18n' => [
                    'syncConfirm' => __('Tüm ürünleri senkronize etmek istediğinize emin misiniz?', 'wc-trendyol')
                ]
            ]);
        }
    }
}