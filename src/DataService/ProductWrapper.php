<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

/**
 * Product wrapper
 *
 * Allows to test your loader implementations without using real products
 */
interface ProductWrapper
{
    /**
     * Returns product SKU
     *
     * @return string
     */
    public function getSku(): string;

    /**
     * Returns product ID
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Check if product is of a type
     *
     * @param string ...$type
     *
     * @return bool
     */
    public function isType(string ...$type): bool;

    /**
     * Updates field in a wrapped product
     *
     * @param string $fieldName
     * @param mixed $value
     *
     * @return void
     */
    public function updateField(string $fieldName, $value): void;
}
