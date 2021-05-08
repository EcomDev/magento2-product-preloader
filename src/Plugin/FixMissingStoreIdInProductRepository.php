<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Plugin;

use Magento\Catalog\Model\ProductRepository;

class FixMissingStoreIdInProductRepository
{
    /**
     * @var string[]
     */
    private $productStoreIds = [];

    /**
     * Replaces missing store id with previously known store id for a product
     *
     * Helps to prevent double load of the same product by other extensions
     *
     * @param ProductRepository $subject
     * @param $productId
     * @param bool $editMode
     * @param null $storeId
     * @param bool $forceReload
     *
     * @return array
     */
    public function beforeGetById(
        ProductRepository $subject,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ): array {
        if ($storeId != null) {
            $this->productStoreIds[$productId] = $storeId;
        }

        $storeId = $this->productStoreIds[$productId] ?? null;

        return [$productId, $editMode, $storeId, $forceReload];
    }
}
