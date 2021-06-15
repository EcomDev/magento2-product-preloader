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
     * Provider of the customer group
     *
     * @var CustomerGroupProvider
     */
    private $customerGroupProvider;

    /**
     * Store manager interface
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * List of provided filter options
     *
     * @var array
     */
    private $options;

    /**
     * MagentoScopeFilter constructor.
     *
     * @param CustomerGroupProvider $customerGroupProvider
     * @param StoreManagerInterface $storeManager
     * @param array $options
     */
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
     * {@inheritDoc}
     */
    public function getWebsiteId(): int
    {
        return (int)($this->options['website_id']
            ?? $this->storeManager->getStore($this->getStoreId())->getWebsiteId());
    }

    /**
     * {@inheritDoc}
     */
    public function getStoreId(): int
    {
        return (int)$this->options['store_id'];
    }

    /**
     * {@inheritDoc}
     */
    public function hasCustomerGroupId(): bool
    {
        return isset($this->options['group_id']);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomerGroupId(): int
    {
        return (int)($this->options['group_id'] ?? $this->customerGroupProvider->getCustomerGroupId());
    }
}
