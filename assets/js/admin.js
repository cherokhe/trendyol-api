jQuery(document).ready(function ($) {
    // Tooltip Etkileşimleri
    $('.stat-info').hover(function () {
        $(this).find('.info-tooltip').fadeIn(200);
    }, function () {
        $(this).find('.info-tooltip').fadeOut(200);
    });

    // Toplu Senkronizasyon
    $('.wc-trendyol-action-btn').on('click', function (e) {
        e.preventDefault();
        if (!confirm(wcTrendyol.i18n.syncConfirm)) return;

        $(this).prop('disabled', true).append('<span class="spinner is-active"></span>');

        $.post(wcTrendyol.ajaxUrl, {
            action: 'wc_trendyol_bulk_sync',
            security: wcTrendyol.nonce
        }).done(function (response) {
            alert(response.data.message);
        }).fail(function (error) {
            alert('Hata oluştu: ' + error.responseJSON.data);
        }).always(function () {
            $('.wc-trendyol-action-btn').prop('disabled', false).find('.spinner').remove();
        });
    });
});