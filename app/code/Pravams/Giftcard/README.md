# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Gift Card

This Giftcard extension allows the customers to gift their loved ones a method to purchase products on a merchant's website.

For example, John may want to gift his Dad an electronic item for Christmas. But instead of buying the product, he buys a gift card worth $100 online. His Dad receives the Email with the Gift card Code. Then he can go to the merchant store and buy his favorite electronic product whether iPhone or iPad from the Merchant website by using the gift card code.

Increase in Sales: This would increase the sales of the merchant's store, as the number of orders will increase due to the use of Gift cards as another way of placing orders.
User-Friendly Site: From the customer perspective it is easier to place orders by applying gift cards to orders and get discounts.
An Emotion of Giving: Customers get a chance to thank people in their lives by giving them a gift. And also feel satisfied with their token of appreciation.


* Frontend:-

    * You can purchase a Gift card product online and send a Gift card code to the receiver.
    * Giftcard can be adedd to cart by providing "gift amount", "Receiver email", "Receiver name" and "Message"
    * Gift card code is an eight-digit code sent to the recipient email.
    * The recipient can use this code to buy any product on the website.
    * The Gift card code can be used any number of times until its value is exhausted.
    * Gift card discount is visible on order totals, PDF, and emails.    
    * This module is designed for the Magento Luma theme
 
* Admin Backend:-

    * You can create any number of Gift card products that are virtual.
    * Gift cards have a minimum and maximum value that can be configured in the admin.
    * Gift card discount is visible on order totals, PDF, and emails.

## Steps to Install

* Copy app/code/Pravams/Giftcard into your magento installation app/code folder
* run the below commands one by one:
```bash
php bin/magento setup:upgrade
```
```bash
php bin/magento setup:di:compile
```
```bash
php bin/magento cache:flush
```
* Login to Magento admin and go to Catalog->Products.
* Click next to "Add Product", on the drop down, and select "Giftcard Product".
* Provide all the details of the giftcard like name, sku, category, description, images etc and save to create the product.
* run the below command
```bash
php bin/magento indexer:reindex 
```
* After reindexing, the refresh the category on which you created the giftcard or search for it in the frontend.
* Click on the giftcard and fill the form to purchase it.


## Test Details
This module has been tested using this tool <https://github.com/magento/magento-coding-standard>. Environment details are:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9



