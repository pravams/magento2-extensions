
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'escaper'
], function (Component, escaper) {
    'use strict';
    
    return Component.extend({
        defaults: {
            template: 'Pravams_Reservation/summary/item/details',
            allowedTags: ['b', 'strong', 'i', 'em', 'u']
        },
        
        /**
         * @param {Object} quoteItem
         * @return {String}
         */
        getNameUnsanitizedHtml: function (quoteItem) {
            var txt = document.createElement('textarea');
            
            txt.innerHtml = quoteItem.name;
            
            return escaper.escapeHtml(txt.value, this.allowedTags);
        },
        
        /**
         * @param {Object} quoteItem
         * @return {String}Magento_Checkout/js/region-updater
         */
        getValue: function (quoteItem) {
            return quoteItem.name;
        },
        
        /**
         * @return {String}
         */
        getStartDate: function () {
            return window.checkoutConfig.reservation_date;
        },
        
        /**
         * @return {String}
         */
        getReservationName: function () {
            return window.checkoutConfig.reservation_name;
        },
  
        /**
         * @return {String}
         */
        getIsReservationProduct: function (quoteItem) {
            //return window.checkoutConfig.quoteItemData[0].product_type;
            console.log(quoteItem);
            console.log(window.checkoutConfig.quoteItemData);
            var flag;
            jQuery.each( window.checkoutConfig.quoteItemData, function( i, val ) {
                var productType = val.product_type;
                var itemId = val.item_id;
                if(itemId == quoteItem.item_id){
                    if(productType == 'reservation'){
                        flag = true;   
                    }else{
                        flag = false;
                    }
                }
                //console.log(val.product_type); 
                //console.log(val.item_id);
            });
            return flag;
        }
        
    });
});

