<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Plugin;

use Magento\Catalog\Model\ProductRepository;

/**
 * Some extensions call product repository within a page without store id
 *
 * This happens in most cases on product view pages after original repsitory with store id was performed.
 * Omitting store_id from a call results in diverging cache key so we walk around it by storing store id for product
 * and re-using it when none specified.
 */
class FixMissingStoreIdInProductRepository
{
    /**
     * List of known store ids for a product
     *
     * @var string[]
     */
    private $productStoreIds = [];

    /**
     * Replaces missing store id with previously known store id for a product
     *
     * Helps to prevent double load of the same product by other extensions
     *
     * @param ProductRepository $subject
     * @param string|int $productId
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
