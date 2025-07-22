# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Reward

This Reward extension for Magento provides a way for the customer to earn Reward points. The reward points are given to the customer for completing an activity. These points can also be redeemed to get discounts on the customer's purchases. This also increases the customers engagement with the site thereby increasing traffic and sales as well.

* Frontend:-

    * Customer earns points for activities like (Registration, Newsletter Subscription, Product Review, Wishlist Sharing and Placing Order)
    * The customer can view the reward points earned for all his activity
    * The customer can redeem the points by entering the number of points on the shopping cart page
    * The cart value is discounted in proportion to the number of points redeemed during checkout    
    * The customer can also see the number of reward points redeemed as well.
    * This module is designed for the Magento Luma theme
 
* Admin Backend:-

    * These points can be proportioned to the currency value, which is configurable in Magento admin. For example (1 Reward point = $10)
    * Ability to enable or disable rewards for specific activity also
    * Assign a custom value of the reward points earned for every activity
    * Can see the reward points earned and redeemed by every customer
    * Please note that there is a restriction/limit of 24 hours in earning reward points from (Product review and Wishlist activities) successively for the customer

## Steps to Install

* Copy app/code/Pravams/Reward into your magento installation app/code folder
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
* Login to Magento admin and go to Stores->Configuration->Pravams->Reward Points
* Review or modify the configuration for earning and redeeming points

## Test Details
This module has been tested with the below environment details:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9



