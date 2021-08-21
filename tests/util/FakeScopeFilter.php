<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\ProductDataPreLoader\DataService\ScopeFilter;

/**
 * Scope filter with predefined values
 */
class FakeScopeFilter implements ScopeFilter
{
    /* @var int */
    private $websiteId;

    /* @var int */
    private $storeId;

    /* @var int|null */
    private $customerGroupId;

    public function __construct(int $websiteId, int $storeId, ?int $customerGroupId = null)
    {

        $this->websiteId = $websiteId;
        $this->storeId = $storeId;
        $this->customerGroupId = $customerGroupId;
    }

    /* @inheritDoc */
    public function getWebsiteId(): int
    {
        return $this->websiteId;
    }

    /* @inheritDoc */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /* @inheritDoc */
    public function hasCustomerGroupId(): bool
    {
        return isset($this->customerGroupId);
    }

    /* @inheritDoc */
    public function getCustomerGroupId(): int
    {
        return $this->customerGroupId ?? 0;
    }
}
