<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

use Magento\Store\Model\StoreManagerInterface;

/**
 * Data scope filter for data pre-loading
 */
class MagentoScopeFilter implements ScopeFilter
{
    /**
     * @var CustomerGroupProvider
     */
    private $customerGroupProvider;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $options;

    public function __construct(
        CustomerGroupProvider $customerGroupProvider,
        StoreManagerInterface $storeManager,
        array $options
    ) {

        $this->customerGroupProvider = $customerGroupProvider;
        $this->storeManager = $storeManager;
        $this->options = $options;
    }

    /**
     * Scope of the filtered data to be loaded
     *
     * @return int
     */
    public function getWebsiteId(): int
    {
        return (int)($this->options['website_id'] ?? $this->storeManager->getStore($this->getStoreId())->getWebsiteId());
    }

    /**
     * Store ID scope of data to be loaded
     *
     * @return int
     */
    public function getStoreId(): int
    {
        return (int)$this->options['store_id'];
    }

    /**
     * Returns true if customer group has been explicitly set
     *
     * @return bool
     */
    public function hasCustomerGroupId(): bool
    {
        return isset($this->options['group_id']);
    }

    /**
     * Returns currently applied customer group
     *
     * Call this method only if your functionality relies on a customer group to provide functionality
     *
     * Otherwise check for hasCustomerGroup() call to make sure you only filter if customer group filter is set
     *
     * @return int
     */
    public function getCustomerGroupId(): int
    {
        return (int)($this->options['group_id'] ?? $this->customerGroupProvider->getCustomerGroupId());
    }

    /**
     * Returns a cache for grouping data loaders together
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        $customerGroupId = 0;

        if ($this->hasCustomerGroupId()) {
            $customerGroupId = $this->getCustomerGroupId();
        }

        return sprintf('%d-%d-%d', $this->getWebsiteId(), $customerGroupId, $this->getStoreId());
    }
}
