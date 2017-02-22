/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
define([
    "jquery",
    "jquery/ui"
], function($){
    "use strict";
    
    $.widget('mage.charity', {
        options: {
        },
        _create: function () {
            this.charityCode = $(this.options.appyCharitySelector);
            this.removeCharityCoupon = $(this.options.removeCharitySelector);

            $(this.options.applyCharityButton).on('click', $.proxy(function () {
                this.charityCode.attr('data-validate', '{required:true}');
                this.removeCharityCoupon.attr('value', '0');
                $(this.element).validation().submit();
            }, this));

            $(this.options.cancelCharityButton).on('click', $.proxy(function () {
                this.charityCode.removeAttr('data-validate');
                this.removeCharityCoupon.attr('value', '1');
                this.element.submit();
            }, this));
        }
    });

    return $.mage.charity;
});