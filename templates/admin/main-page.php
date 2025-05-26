<div class="wrap">
    <h1><?php esc_html_e('WooCommerce Trendyol Entegrasyonu', 'wc-trendyol'); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields('wc_trendyol_settings');
        do_settings_sections('wc_trendyol');
        submit_button();
        ?>
    </form>
    
    <div class="wc-trendyol-sync-section">
        <h2><?php esc_html_e('Ürün Senkronizasyonu', 'wc-trendyol'); ?></h2>
        <button id="wc-trendyol-sync-products" class="button button-primary">
            <?php esc_html_e('Ürünleri Senkronize Et', 'wc-trendyol'); ?>
        </button>
        <div id="wc-trendyol-sync-progress"></div>
    </div>
</div>