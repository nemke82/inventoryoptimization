# Module Nemke82 InventoryOptimization

    ``nemke82/module-inventoryoptimization``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Module that optimize inventory_reservation table by adding Materilized View and aggregated table. It also rewrite
Magento\Inventory\Model\ResourceModel\GetReservationsQuantity Core functionality by calling view with agreggated data.

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Nemke82`
 - Enable the module by running `php bin/magento module:enable Nemke82_InventoryOptimization`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer
 - Install the module composer by running `composer require nemke82/module-inventoryoptimization`
 - enable the module by running `php bin/magento module:enable Nemke82_InventoryOptimization`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush

PHP Unit test available with the following command:
```
vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist vendor/nemke82/inventoryoptimization/Test/Unit/Plugin/Model/GetReservationsQuantityPluginTest.php
```

