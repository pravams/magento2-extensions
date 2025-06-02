# magento2-extensions
Magento 2 custom extensions and themes that enhance magento 2 features:

## 1.) Recurring Order

This Recurring Order extension for Magento makes it easier for customers to create repeat orders by creating subscription orders based on a frequency for offline payment methods.  With this Recurring Order extension, customers can use it to create a subscription for the product. And the order will be placed automatically every week based on the frequency that they select.

* Frontend:-

    * You can add any number of products for subscription
    * Subscription can be customized to any frequency which can be daily, weekly, monthly, etc
    * The subscription can be created for any shipping method
    * The subscription is currently supported for simple products only
    * The subscription can be created for offline payment methods only
 
* Admin Backend:-

    * View the subscription details created by the customer from Magento Admin.
    * Ability to make the subscription inactive, active, or delete it.
    * View the orders placed through the subscription.

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/RecurringOrder>


## 2.) Headless Theme

This Magento theme, removes the default "head"(mostly CSS) in Magento, and makes it very easy for the front-end developers to replace this head with another head(CSS design) and create a new theme for Magento very quickly, so it is named as a Headless theme.

* Features:-

    * It does not inherit the out of the box Magento’s Luma or the Blank theme’s design or layout. But it is using an open source W3 CSS example template as the base theme design and layout. And this entirely different CSS and HTML is integrated into Magento as a shopping cart theme.
    * This is a pure "Frontend theme" with changes in HTML, CSS and Javascript only and there are no modifications in the app/code folder.
    * For the checkout to happen, it is using the default or Out of the box existing REST APIs of Magento.
    * It is built as a SPA(Single Page Application), which means that all the features of this theme can be accessed without reloading or refreshing the page.
    * This theme is also open source, so it can be customised easily to convert it into a full fledged eCommerce website as well.
    * It is created primarily to help the Frontend developer quickly integrate their new designs in the form of HTML, CSS into Magento easily.
    * It is very simple to use and understand, and requires very less backend module creation knowledge, to customise this theme.
 
* Key points :-
    * It allows only guest customer checkout currently
    * It allow first level category navigation
    * We can List only Simple products
    * We can View only Simple products
    * View cart and Remove items if needed
    * Add Shipping and Billing Address 
    * Select Shipping method
    * Select Offline payment method
    * Place order only as a guest user


**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/design/frontend/Pravams/headless>


