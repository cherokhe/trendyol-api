<?php
if (!defined('ABSPATH')) {
    exit;
}

$options = get_option('wc_trendyol_options');
$categories = WC_Trendyol_API::get_categories();
?>
<div class="wrap wc-trendyol-settings">
    <h1><?php esc_html_e('Trendyol Entegrasyon Ayarları', 'wc-trendyol'); ?></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('wc_trendyol_settings'); ?>
        <?php do_settings_sections('wc_trendyol_settings'); ?>
        
        <div class="wc-trendyol-settings-section">
            <h2><?php esc_html_e('API Ayarları', 'wc-trendyol'); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('API Anahtarı', 'wc-trendyol'); ?></th>
                    <td>
                        <input type="text" name="wc_trendyol_options[api_key]" 
                               value="<?php echo esc_attr($options['api_key'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('API Şifresi', 'wc-trendyol'); ?></th>
                    <td>
                        <input type="password" name="wc_trendyol_options[api_secret]" 
                               value="<?php echo esc_attr($options['api_secret'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Satıcı ID', 'wc-trendyol'); ?></th>
                    <td>
                        <input type="text" name="wc_trendyol_options[supplier_id]" 
                               value="<?php echo esc_attr($options['supplier_id'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Varsayılan Kategori', 'wc-trendyol'); ?></th>
                    <td>
                        <select name="wc_trendyol_options[default_category]" class="wc-enhanced-select">
                            <option value="0"><?php esc_html_e('Seçiniz...', 'wc-trendyol'); ?></option>
                            <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo esc_attr($category['id']); ?>"
                                <?php selected($options['default_category'] ?? 0, $category['id']); ?>>
                                <?php echo esc_html($category['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="wc-trendyol-settings-section">
            <h2><?php esc_html_e('Senkronizasyon Ayarları', 'wc-trendyol'); ?></h2>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('Otomatik Senkronizasyon', 'wc-trendyol'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="wc_trendyol_options[auto_sync]" 
                                   value="yes" <?php checked($options['auto_sync'] ?? 'no',