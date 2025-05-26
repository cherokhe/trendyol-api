<div class="wrap wc-trendyol-category-mapping">
    <h1><?php esc_html_e('WooCommerce - Trendyol Kategori Eşleştirme', 'wc-trendyol'); ?></h1>
    
    <?php if (empty($trendyol_categories)) : ?>
        <div class="notice notice-error">
            <p><?php esc_html_e('Trendyol kategorileri alınamadı. API ayarlarını kontrol edin.', 'wc-trendyol'); ?></p>
        </div>
    <?php endif; ?>
    
    <form method="post" action="options.php">
        <?php settings_fields('wc_trendyol_category_mapping'); ?>
        <?php do_settings_sections('wc_trendyol_category_mapping'); ?>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th width="30%"><?php esc_html_e('WooCommerce Kategorisi', 'wc-trendyol'); ?></th>
                    <th width="70%"><?php esc_html_e('Trendyol Kategorisi', 'wc-trendyol'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wc_categories as $wc_cat) : ?>
                <tr>
                    <td><?php echo esc_html($wc_cat->name); ?></td>
                    <td>
                        <select name="wc_trendyol_category_mapping[<?php echo (int)$wc_cat->term_id; ?>]" class="wc-trendyol-category-select">
                            <option value="0"><?php esc_html_e('Seçiniz...', 'wc-trendyol'); ?></option>
                            <?php foreach ($trendyol_categories as $ty_cat) : ?>
                            <option value="<?php echo (int)$ty_cat['id']; ?>"
                                <?php selected($mappings[$wc_cat->term_id] ?? 0, $ty_cat['id']); ?>>
                                <?php echo esc_html($ty_cat['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php submit_button(__('Eşleştirmeleri Kaydet', 'wc-trendyol')); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    $('.wc-trendyol-category-select').select2({
        width: '100%',
        placeholder: '<?php esc_html_e("Kategori ara...", "wc-trendyol"); ?>',
        allowClear: true
    });
});
</script>