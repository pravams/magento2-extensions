# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Core

This module has to code which is common some of the modules. Below are the list of modules for which this module is madatory for installation and the extensions to work completely.

* Modules are:-

    * Pravams_RecurringOrder
    * Pravams_Reward   
    * Pravams_Chat
    * Pravams_Giftcard

## Steps to Install

* Copy app/code/Pravams/Core your magento installation app/code folder
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

## Test Details
This module has been tested using the below Environment are:-
* Magento 2.4.9
* Ubuntu 24.04.3 LTS
* PHP 8.5.6
* mysql Ver 8.0.45
* Apache/2.4.58
* Opensearch 2.19.5
* Composer version 2.9.5




