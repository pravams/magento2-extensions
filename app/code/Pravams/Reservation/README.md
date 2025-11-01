# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Reservation

This Reservation or Bookings extension for Magento provides a way for the customers to buy products that need a reservation (or that require a date input mandatorily) while adding them to the cart.
For example, the owner of a guest house or hotel can use this extension, where his customers can book the dates of their stay.


* Frontend:-

    * Customers can view the reservation products list.
    * Customers can add the product after providing the reservation name and selecting the date.
    * Customer can see his selected date during all the steps of checkout.
    * Customer can see the booked dates on his email and pdf also.
    * Ideal Customers who may want this extension would be Movie Ticket Sellers, Hotel Rooms seller, Food reservation sites for restaurants, event organizing, seat bookings in travel etc. and many other such places who have to collect the date and name on thier product for sale.

* Admin Backend:-

    * Admin can log into admin and go to Pravams->All Reservations. And he can view, search the orders placed by reservation name, order# or booking place name.
    * Admin can also see the customer's selected dates of the booking.
    * The inventory is deducted after the purchase for the booking place, so Admin can estimate accordingly
## Steps to Install

* Copy app/code/Pravams/Reservation into your magento installation app/code folder
* run the below commands one by one:
```bash
php bin/magento setup:upgrade
```
```bash
php bin/magento setup:di:compile
```

## Key Points
* Go to Stores -> Product.
* Step 1. In the grid under the attribute_code, type 'Price'. Click the attribute set that has "Default Label" same as price. After clicking on the link, check the value next to attribute_id, in the browser URL. So now we should know that the attribute code for price is 79.
* Step 2. Repeat the same process as Step 1, but here the search term will be "Special Price". Note its attribute id as well.
* Step 3. Repeat the same process as Step 1, but here the search term will be "Special Price From Date". Note its attribute id as well.
* Step 4. Repeat the same process as Step 1, but here the search term will be "Special Price To Date". Note its attribute id as well.

* The attribute ids for your magento installation may be different. Therefore I had to give this explanation.
* Now take a backup of your table 'catalog_eav_attribute' and then run the below sql queries one by one by replacing the attribute ids.

* UPDATE `magento`.`catalog_eav_attribute` SET `apply_to` = 'simple,virtual,bundle,downloadable,configurable,reservation' WHERE (`attribute_id` = '77');
* UPDATE `magento`.`catalog_eav_attribute` SET `apply_to` = 'simple,virtual,bundle,downloadable,configurable,reservation' WHERE (`attribute_id` = '78');
* UPDATE `magento`.`catalog_eav_attribute` SET `apply_to` = 'simple,virtual,bundle,downloadable,configurable,reservation' WHERE (`attribute_id` = '79');
* UPDATE `magento`.`catalog_eav_attribute` SET `apply_to` = 'simple,virtual,bundle,downloadable,configurable,reservation' WHERE (`attribute_id` = '80');
* Now go to the Catalog->Product->click on Add Product drop down. Then select Reservation as the product type.
* Fill the details like name, price, qty, description, images etc and save this product
* Run the below command for reindexing
```bash
php bin/magento indexer:reindex
```
```bash
php bin/magento cache:flush
```



## Test Details
This module has been tested with the below environment details:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9





