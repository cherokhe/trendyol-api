<?php
defined('ABSPATH') || exit;

class WC_Trendyol_Product_Sync {
    public static function sync_product($product, $category_id = null) {
        try {
            $admin_menu = new WC_Trendyol_Admin_Menu();
            
            if (!$category_id) {
                $category_id = get_post_meta($product->get_id(), '_trendyol_category', true);
                if (!$category_id) {
                    $category_id = get_option('wc_trendyol_options')['default_category'] ?? 0;
                    if (!$category_id) {
                        throw new Exception(__('Ürün için Trendyol kategorisi belirtilmemiş!', 'wc-trendyol'));
                    }
                }
            }

            $product_data = self::prepare_product_data($product, $category_id);
            $response = WC_Trendyol_API::create_product($product_data);

            if (is_wp_error($response)) {
                throw new Exception($response->get_error_message());
            }

            $body = json_decode(wp_remote_retrieve_body($response), true);
            
            if (wp_remote_retrieve_response_code($response) === 200 && isset($body['batchRequestId'])) {
                update_post_meta($product->get_id(), '_trendyol_id', $body['batchRequestId']);
                update_post_meta($product->get_id(), '_trendyol_category', $category_id);
                update_post_meta($product->get_id(), '_trendyol_last_sync', current_time('mysql'));
                
                $admin_menu->log_activity(
                    $product->get_id(),
                    'success',
                    __('Ürün başarıyla senkronize edildi', 'wc-trendyol')
                );
                
                return true;
            }

            throw new Exception(__('Trendyol API hatası: ', 'wc-trendyol') . ($body['message'] ?? __('Bilinmeyen hata', 'wc-trendyol')));

        } catch (Exception $e) {
            $admin_menu->log_activity(
                $product->get_id(),
                'error',
                $e->getMessage()
            );
            return new WP_Error('sync_error', $e->getMessage());
        }
    }

    private static function prepare_product_data($product, $category_id) {
        $images = [];
        $attachment_ids = $product->get_gallery_image_ids();
        
        if ($product->get_image_id()) {
            array_unshift($attachment_ids, $product->get_image_id());
        }
        
        foreach ($attachment_ids as $attachment_id) {
            $image_url = wp_get_attachment_image_url($attachment_id, 'full');
            if ($image_url) $images[] = $image_url;
        }

        return [
            'items' => [[
                'barcode' => $product->get_sku() ?: 'WC-' . $product->get_id(),
                'title' => $product->get_name(),
                'productMainId' => $product->get_sku() ?: 'WC-' . $product->get_id(),
                'categoryId' => $category_id,
                'quantity' => $product->get_stock_quantity() ?: 0,
                'stockCode' => $product->get_sku() ?: 'WC-' . $product->get_id(),
                'dimensionalWeight' => 1,
                'description' => $product->get_description(),
                'currencyType' => 'TRY',
                'listPrice' => $product->get_regular_price(),
                'salePrice' => $product->get_price(),
                'cargoCompanyId' => 1,
                'images' => $images,
                'vatRate' => 18,
                'shipmentAddressId' => 1,
                'returningAddressId' => 1
            ]]
        ];
    }
}