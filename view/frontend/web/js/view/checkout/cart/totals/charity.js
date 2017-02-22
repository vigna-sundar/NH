/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define(
    [
        'Sundial_CommunityCommerce/js/view/checkout/summary/charity'
    ],
    function (Component) {
        'use strict';
		

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return true;
            }
			
        });
    }
);