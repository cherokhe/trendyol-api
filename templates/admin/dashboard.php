<div class="wrap wc-trendyol-dashboard">
    <div class="wc-trendyol-header">
        <h1><span class="dashicons dashicons-networking"></span> <?php esc_html_e('Trendyol Entegrasyon Paneli', 'wc-trendyol'); ?></h1>
        <div class="wc-trendyol-actions">
            <a href="<?php echo esc_url(admin_url('admin.php?page=wc-trendyol-settings')); ?>" class="button button-primary">
                <span class="dashicons dashicons-admin-generic"></span>
                <?php esc_html_e('Ayarlar', 'wc-trendyol'); ?>
            </a>
        </div>
    </div>

    <div class="wc-trendyol-stats-grid">
        <!-- Senkronize Edilen Ürünler -->
        <div class="wc-trendyol-stat-card">
            <div class="stat-icon success">
                <span class="dashicons dashicons-yes"></span>
            </div>
            <div class="stat-content">
                <h3>1,245</h3>
                <p><?php esc_html_e('Senkronize Ürün', 'wc-trendyol'); ?></p>
            </div>
            <div class="stat-info">
                <span class="dashicons dashicons-info"></span>
                <div class="info-tooltip">
                    <?php esc_html_e('Trendyol ile senkronize edilen toplam ürün sayısı', 'wc-trendyol'); ?>
                </div>
            </div>
        </div>

        <!-- Diğer İstatistik Kartları -->
    </div>

    <div class="wc-trendyol-quick-links">
        <div class="wc-trendyol-card">
            <h2><span class="dashicons dashicons-migrate"></span> <?php esc_html_e('Hızlı İşlemler', 'wc-trendyol'); ?></h2>
            <div class="card-content">
                <button class="button button-primary wc-trendyol-action-btn">
                    <span class="dashicons dashicons-update"></span>
                    <?php esc_html_e('Toplu Senkronizasyon', 'wc-trendyol'); ?>
                </button>
                <a href="<?php echo esc_url(admin_url('admin.php?page=wc-trendyol-product-mapping')); ?>" class="button">
                    <span class="dashicons dashicons-tag"></span>
                    <?php esc_html_e('Ürün Eşleştirme', 'wc-trendyol'); ?>
                </a>
            </div>
        </div>
    </div>
</div>