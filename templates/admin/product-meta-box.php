<div class="wc-trendyol-meta-box">
    <div class="wc-trendyol-field">
        <label for="_trendyol_category">
            <strong><?php esc_html_e('Trendyol Kategorisi', 'wc-trendyol'); ?></strong>
        </label>
        <select name="_trendyol_category" id="_trendyol_category" class="wc-enhanced-select" style="width:100%">
            <option value="0"><?php esc_html_e('Seçiniz...', 'wc-trendyol'); ?></option>
            <?php foreach ($trendyol_categories as $category) : ?>
            <option value="<?php echo esc_attr($category['id']); ?>"
                <?php selected($trendyol_category, $category['id']); ?>>
                <?php echo esc_html($category['name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="wc-trendyol-field" style="margin-top:15px;">
        <button type="button" id="wc-trendyol-sync-now" class="button button-primary" 
            data-product-id="<?php echo esc_attr($post->ID); ?>">
            <?php esc_html_e('Trendyol\'a Gönder', 'wc-trendyol'); ?>
        </button>
        <span id="wc-trendyol-sync-status" style="margin-left:10px;"></span>
    </div>

    <?php if ($trendyol_id) : ?>
    <div class="wc-trendyol-field" style="margin-top:15px;">
        <p>
            <strong><?php esc_html_e('Trendyol ID:', 'wc-trendyol'); ?></strong>
            <?php echo esc_html($trendyol_id); ?>
        </p>
    </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    $('#_trendyol_category').select2({
        width: '100%',
        placeholder: '<?php esc_html_e("Kategori seçin...", "wc-trendyol"); ?>'
    });

    $('#wc-trendyol-sync-now').on('click', function() {
        var $button = $(this);
        var product_id = $button.data('product-id');
        var category_id = $('#_trendyol_category').val();

        if (!category_id || category_id == '0') {
            alert('<?php esc_html_e("Lütfen bir Trendyol kategorisi seçin!", "wc-trendyol"); ?>');
            return;
        }

        $button.prop('disabled', true).text('<?php esc_html_e("Gönderiliyor...", "wc-trendyol"); ?>');
        $('#wc-trendyol-sync-status').html('');

        $.post(ajaxurl, {
            action: 'wc_trendyol_sync_single_product',
            product_id: product_id,
            category_id: category_id,
            security: '<?php echo wp_create_nonce("wc-trendyol-sync"); ?>'
        }).done(function(response) {
            if (response.success) {
                $('#wc-trendyol-sync-status').html('<span style="color:green"><?php esc_html_e("Başarıyla gönderildi!", "wc-trendyol"); ?></span>');
                location.reload();
            } else {
                $('#wc-trendyol-sync-status').html('<span style="color:red">' + response.data + '</span>');
            }
        }).always(function() {
            $button.prop('disabled', false).text('<?php esc_html_e("Trendyol\'a Gönder", "wc-trendyol"); ?>');
        });
    });
});
</script>