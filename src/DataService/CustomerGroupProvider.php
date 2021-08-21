<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

/**
 * Customer group provider for dynamic resolution of it
 */
interface CustomerGroupProvider
{
    /**
     * Return current customer group
     *
     * @return int
     */
    public function getCustomerGroupId(): int;
}
