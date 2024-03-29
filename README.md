# Product Data Pre-Loader

Magento platform code and third-party extensions in a lot of cases produce redundant database queries on product collections load.

This module provides an easy way to pre-load data for product collections like prices, stock data, and many more by using different types of load types.
Right now it supports 3 types of loaded product collections:

- `list` Products that are using price index in selection, so it is safe to use stale index data for data loader
- `cart` Products that are used to calculate customers shopping cart and require accurate data to be loaded from database
- `other` Products that are not falling into any of the above categories

In order to pre-load data for a product collection, you need to implement `EcomDev\ProductDataPreLoader\DataService\DataLoader` interface with such methods: 
- `isApplicable(string $type): bool` method that is used to decide if your loader compatible with specific product collection type.
- `load(ScopeFilter $filter, ProductWrapper[] $products): array` method that preloads data into `LoadService` that can be used later to access data by your loader id.


Custom loaders should be added to `LoadService` object via DI configuration like this:

```xml
<type name="EcomDev\ProductDataPreLoader\DataService\LoadService">
    <arguments>
        <argument name="loaders" xsi:type="array">
            <item name="my_custom_loader" xsi:type="object">My\Module\Loader\MyCustomLoader</item>
        </argument>
    </arguments>
</type>
```

## Installation

Given EOL of Composer 1 all new packagist packages are not published for some time. So best way to keep your install up-to-date is to use Composer 2.0.
```bash
composer require ecomdev/magento2-product-data-preloader
```
## Usage Example
This [sample module](https://github.com/EcomDev/example-preloading-configurable-product) implements optimistic preloader for configurable product data without taking into account simple product status for:

- Price of configurable product on product list
- Stock availability from MSI for configurable product
- Minimal tier price across simple products for configurable
