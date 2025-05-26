<?php
defined('ABSPATH') || exit;

class WC_Trendyol_API {
    private static $api_url = 'https://api.trendyol.com/sapigw/';
    
    public static function get_categories() {
        $options = get_option('wc_trendyol_options');
        if (empty($options['api_key']) || empty($options['api_secret'])) {
            return new WP_Error('api_credentials', __('API bilgileri eksik', 'wc-trendyol'));
        }

        $cache_key = 'wc_trendyol_categories_' . md5($options['api_key']);
        if ($cached = get_transient($cache_key)) {
            return $cached;
        }

        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($options['api_key'] . ':' . $options['api_secret'])
            ),
            'timeout' => 30
        );

        $response = wp_remote_get(self::$api_url . 'product-categories', $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['categories'])) {
            set_transient($cache_key, $body['categories'], 12 * HOUR_IN_SECONDS);
            return $body['categories'];
        }

        return new WP_Error('api_error', __('Kategoriler alınamadı', 'wc-trendyol'));
    }

    public static function create_product($product_data) {
        $options = get_option('wc_trendyol_options');
        $url = self::$api_url . 'suppliers/' . $options['supplier_id'] . '/products';

        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($options['api_key'] . ':' . $options['api_secret'])
            ),
            'body' => json_encode($product_data),
            'timeout' => 45
        );

        return wp_remote_post($url, $args);
    }
}