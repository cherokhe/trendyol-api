jQuery(document).ready(function($) {
    $('.wc-trendyol-category-select').select2({
        width: '100%',
        placeholder: wc_trendyol_mapping_vars.i18n.search_placeholder,
        allowClear: true,
        minimumResultsForSearch: 3
    });
    
    // Büyük listelerde performans için
    $('.wc-trendyol-category-select').on('select2:open', function() {
        $('.select2-search__field').attr('placeholder', wc_trendyol_mapping_vars.i18n.search_placeholder);
    });
});