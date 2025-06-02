# magento2-theme
Magento 2 custom theme that enhances magento 2 features:

## 1.) Headless Theme

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

## Steps to Install

* Copy app/design/frontend/Pravams/headless into your magento installation app/design/frontend/ folder
* run the below commands one by one:
```bash
php bin/magento setup:upgrade
```
```bash
php bin/magento setup:di:compile
```
```bash
php bin/magento setup:static-content:deploy -f
```
```bash
php bin/magento cache:flush
```

* Enable Guest API access:-Stores -> Configuration -> SERVICES -> Magento Web API -> Web API Security -> Allow Anonymous Guest Access
    * Yes
* Enable the headless theme in Magento:Login to Magento admin and go to:--
    * Content -> Design -> Configuration 
    * Click on edit in the Actions column of the Store for which you want to change the theme
    * In Default Theme -> Applied Theme dropdown select "Headless"
    * Click on Save configuration
    * Clear cache 
    * Refresh the Frontend home page in your browser
* Update the footer contact details by logging into the Magento Admin and change the values for:-
    * Stores -> Configuration -> GENERAL -> General -> Store Information -> Store Name
    * Your store name
    * Stores -> Configuration -> GENERAL -> General -> Store Information -> Store Phone Number
    * 123456789
    * Stores -> Configuration -> GENERAL -> Store Email Addresses -> General Contact -> Sender Email
    * owner@example.com

* Optional: 
    * Add CMS pages in footer:-- 
    * Open app/design/frontend/Pravams/headless/Magento_Theme/templates/home-headless.phtml. 
    * Search for this line in the html 
    ```bash
    <p><a href="#" cmspageid="4">Privacy and Cookie Policy</a></p>
    ```
    * Add another line for another CMS page, and change the "cmspageid" value to your Pageid and the name of the page should be inside the a tag.



## Test Details
This module has been tested using this tool <https://github.com/magento/magento-coding-standard>
Environment details are:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9


