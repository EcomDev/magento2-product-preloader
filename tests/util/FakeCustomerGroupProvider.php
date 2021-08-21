<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\ProductDataPreLoader\DataService\CustomerGroupProvider;

/**
 * FakeCustomerGroupProvider
 */
class FakeCustomerGroupProvider implements CustomerGroupProvider
{
    private $customerGroupId;

    private function __construct(int $customerGroupId)
    {
        $this->customerGroupId = $customerGroupId;
    }

    public static function create(int $customerGroupId): self
    {
        return new self($customerGroupId);
    }

    public function getCustomerGroupId(): int
    {
        return $this->customerGroupId;
    }
}
