define([
    'jquery',
    'mage/translate'
], function ($, $t) {
    'use strict';

    return function (configurable) {
        $.widget('mage.configurable', $['mage']['configurable'], {
            _reloadPrice: function (element) {
                this._super(element);
                let productStock = this.options.spConfig.stockQuantities[this.simpleProduct],
                    stockHtml = '#simple_product_stock';
                if (productStock) {
                    let left = $t(' stock');
                    if (productStock > 1) {
                        left = $t(' stocks');
                    }
                    $(stockHtml).html('<strong>' + $t('Available: ') + '</strong>' + productStock + left);
                    $(stockHtml).show();
                } else {
                    $(stockHtml).hide();
                    $(stockHtml).html('');
                }
            }
        });

        return $['mage']['configurable'];
    };
});
