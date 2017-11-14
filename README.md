# Magento-2-GTID-Safe-URL-Rewrite-Fallback

Magento 2 module that forces the category save observer to fall back to a method that doesn't require temporary tables. This allows GTID consistent category saves, at the expense of some performance.
