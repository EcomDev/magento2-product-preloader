<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

/**
 * Data scope filter for data pre-loading
 */
interface ScopeFilter
{
    /**
     * Scope of the filtered data to be loaded
     *
     * @return int
     */
    public function getWebsiteId(): int;

    /**
     * Store ID scope of data to be loaded
     *
     * @return int
     */
    public function getStoreId(): int;

    /**
     * Returns true if customer group has been explicitly set
     *
     * @return bool
     */
    public function hasCustomerGroupId(): bool;

    /**
     * Returns currently applied customer group
     *
     * Call this method only if your functionality relies on a customer group to provide functionality
     *
     * Otherwise check for hasCustomerGroup() call to make sure you only filter if customer group filter is set
     *
     * @return int
     */
    public function getCustomerGroupId(): int;

    /**
     * Returns a cache for grouping data loaders together
     *
     * @return string
     */
    public function getCacheKey(): string;
}
