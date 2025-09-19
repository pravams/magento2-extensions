# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Ticket

This Ticket extension for Magento provides a way for the customers to create a Support Ticket for ongoing communication with website support team. It allows the customer to write down thier issues or questions in details with screenshots etc on the website and expect a reliable resolution. 
This provides a comprehensive way for the customers to track and ask questions related to the website, products purchase or returns, thereby increasing customer satisfaction. This also increases the customers engagement with the site thereby increasing traffic and sales as well.

* Frontend:-

    * Customer can create a Support ticket for the website support team.
    * Cusomer can set priority of the issue, indicating its urgency.        
    * Customer can upload images in the ticket.
    * Customer can close the ticket after it is resolved.    
    * An email notification is sent to the website support, when customer creates a ticket or replies to it.
    * SPAM block to avoid excessive ticket and reply posting.

* Admin Backend:-

    * Can view, search and filter the tickets created by the customer.
    * Can reply to the ticket and upload images also.    
    * Admin can close a ticket also, on behalf of the customer.    
    * An email notification is sent to the customer on every reply also.
    * SPAM block to avoid excessive reply posting.

## Steps to Install

* Copy app/code/Pravams/Ticket into your magento installation app/code folder
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
* Go to Stores->Configuration->General->General->Store Information->Store Name. Please provide the store name, as it will be used in the email notifications as part of the subject.
* Go to Stores->Configuration->General->Store Email Addresses->Customer Support->Sender Name. Please provide the sender name and sender email, as it will be used in the email notifications as sender of emails for this extension.


## Key Points
* The customer can create a successive tickets after 8 hours time interval to block un-necessary spamming.
* The customer or admin can send successive replies after 1 hour time only to block un-necessary spamming.
* Admin cannot create a ticket.
* The ticket is assigned to the admin user, who is replying to the ticket.

## Test Details
This module has been tested with the below environment details:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9



