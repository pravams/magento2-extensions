# magento2-extensions
Magento 2 custom extensions that enhance magento 2 features:

## Core

This module has the code which is common to some of the modules. Below are the list of modules for which this module is madatory for installation and the extensions to work completely.

* Modules are:-

    * Pravams_RecurringOrder
    * Pravams_Reward    

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
* Magento 2.4.8
* Ubuntu 22.04.4 LTS
* PHP 8.4.6
* mysql Ver 8.4.5
* Apache/2.4.52
* Opensearch 2.19.1
* Composer version 2.7.9



