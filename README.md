# Magento 2 GTID Safe URL Rewrite Fallback

Magento 2 module that forces the category save/update observers to fall back to a method that doesn't require temporary tables. This allows GTID consistent category saves, at the expense of some performance.

## Why?

Well, Magento 2 appears to have a much higher development priority on overall application performance than it does on scalable deployment, especially in cloud environments. This module is a quick workaround for a particular issue in many cloud environments that require binary safe transactions and GTID consistent transactions... usually MySQL compatible managed databases with some sort of replication for better availability and failover. Since early versions of Magento 2.1.x, the way category rewrites were rebuilt was changed to make it more efficient; unfortunately, it did so by using temporary tables, which violates GTID consistency, and will cause the 'Something went wrong while saving this category' error if a change was made to the url key, 'is_anchor', or to the product list when saving a category. 

This module is a quick workaround that forces Magento to fall back to a (currently deprecated) method that does not use temporary table or violate GTID consistency... thus solving the problem forever... ;-p

A more permanent solution involving permanent tables is in the works, but this should fix the issue for anyone who needs to save their Magento categories RIGHT NOW! :-D

## Installation

Installation is available via composer. The package name is bangerkuwranger/magento2-gtid-safe-url-rewrite-fallback. Just run these commands at your Magento root:

`composer require bangerkuwranger/magento2-gtid-safe-url-rewrite-fallback`

`php bin/magento module:enable Bangerkuwranger_GtidSafeUrlRewriteFallback`

`php bin/magento setup:upgrade`

`php bin/magento setup:di:compile`

`php bin/magento cache:flush`
