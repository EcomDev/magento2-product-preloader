<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

/**
 * Interface for multiple hooks that are going to be used to preload data
 * for product collection
 */
interface DataLoader
{
    const TYPE_CART = 'cart';
    const TYPE_LIST = 'list';
    const TYPE_OTHER = 'other';

    /**
     * Preloads data for a product by using product adapter
     *
     * Result should be keyed by ID of the supplied products.
     *
     * @param ScopeFilter $filter
     * @param ProductWrapper[] $products
     *
     * @return array
     */
    public function load(ScopeFilter $filter, array $products): array;

    /**
     * Checks if the preloader is applicable for this type of data.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isApplicable(string $type): bool;
}
