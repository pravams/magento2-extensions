# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Chat

This Chat extension for Magento provides a way for the customers to chat with the website support or Magento admin users. This provides a quick and easy way for the customers to ask questions or clear doubts, thereby increasing customer satisfaction. This also increases the customers engagement with the site thereby increasing traffic and sales as well. This exension is using minimum javascript, so the site performance is not affected by this extension.

* Frontend:-

    * Customer can chat with the website support team
    * Customer has to log in to start chatting.
    * The customer can refresh the page to see new messages
    * Cusomer can also see, if thier messages are read by the Support team
    * SPAM block to avoid excessive messaging

* Admin Backend:-

    * They can chat with mutiple customers from the same place
    * They can also delete the chat
    * Admin can also see, if thier messages are read by the Customer
    * SPAM block to avoid excessive messaging
    * Admin can blacklist a customer and disable his chat

## Steps to Install

* Copy app/code/Pravams/Chat into your magento installation app/code folder
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
* Customer will see a "Login to Chat" at the right footer of the website to start a chat
* Admin can log into magento admin, and on the left nvaigation, click on "Pravams Chat"-> "All Chat Messages" to reply to chats

## Key Points
* The admin can only reply to a message from the customer in the chat. They cannot start a conversation with any new customer.
* Conversation can only be started by the customer.
* Only text messages are allowed. No media upload in the chat is allowed.
* Guest cannot chat, they have to register and log in.
* The chat box will show on all the pages, except the Checkout steps (Shipping, Payment/Review).


## Test Details
This module has been tested with the below environment details:-
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9



