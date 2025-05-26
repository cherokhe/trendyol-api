<div class="wrap wc-trendyol-product-mapping">
    <div class="wc-trendyol-header">
        <h1><span class="dashicons dashicons-tag"></span> <?php esc_html_e('Ürün Eşleştirme Yönetimi', 'wc-trendyol'); ?></h1>
        <div class="wc-trendyol-actions">
            <button class="button button-primary" id="wc-trendyol-sync-selected">
                <span class="dashicons dashicons-update"></span>
                <?php esc_html_e('Seçilileri Senkronize Et', 'wc-trendyol'); ?>
            </button>
        </div>
    </div>

    <div class="wc-trendyol-product-grid">
        <div class="wc-trendyol-filters">
            <input type="text" placeholder="<?php esc_attr_e('Ürün ara...', 'wc-trendyol'); ?>" class="wc-trendyol-search">
            <select class="wc-trendyol-filter-select">
                <option value="all"><?php esc_html_e('Tüm Ürünler', 'wc-trendyol'); ?></option>
                <option value="synced"><?php esc_html_e('Senkronize Edilenler', 'wc-trendyol'); ?></option>
                <option value="unsynced"><?php esc_html_e('Senkronize Edilmeyenler', 'wc-trendyol'); ?></option>
            </select>
        </div>

        <div class="wc-trendyol-product-list">
            <?php // Ürün listesi veritabanından çekilecek ?>
            <div class="wc-trendyol-product-item">
                <div class="product-checkbox">
                    <input type="checkbox">
                </div>
                <div class="product-thumbnail">
                    <img src="<?php echo WC_TRENDYOL_ASSETS_URL . 'images/product-placeholder.jpg'; ?>" width="60">
                </div>
                <div class="product-info">
                    <h3>Örnek Ürün</h3>
                    <p>SKU: WC-123</p>
                </div>
                <div class="product-status">
                    <span class="dashicons dashicons-yes-alt success"></span>
                    <span class="status-text"><?php esc_html_e('Senkronize Edildi', 'wc-trendyol'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>