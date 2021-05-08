<?php

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
     * @return bool
     */
    public function isType(string ...$type): bool;

    /**
     * Updates field in wrapped product
     *
     * @param string $fieldName
     * @param $value
     */
    public function updateField(string $fieldName, $value): void;
}
