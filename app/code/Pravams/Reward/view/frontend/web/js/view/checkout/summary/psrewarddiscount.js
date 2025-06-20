define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total'
    ],
    function ($,Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Pravams_Reward/checkout/summary/psrewarddiscount'
            },
            isDisplayedPsrewarddiscount : function(){
                var canDisplay = true;
                if(window.checkoutConfig.ps_reward_points != undefined){
                    canDisplay = true;
                }else{
                    canDisplay = false;
                }                
                return canDisplay;
            },
            getPsRewardDiscount : function(){
                return window.checkoutConfig.ps_reward_points;
            }
       });
   }
);