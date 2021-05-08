<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

use Magento\Catalog\Model\Product;

/**
 * Product wrapper
 */
class MagentoProductWrapper implements ProductWrapper
{
    /**
     * @var Product
     */
    private $product;

    /**
     * MagentoProductWrapper constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Returns product SKU
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->product->getSku();
    }

    /**
     * Returns product ID
     *
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->product->getId();
    }

    /**
     * Check if product is of a type
     *
     * @param string ...$type
     * @return bool
     */
    public function isType(string ...$type): bool
    {
        return in_array($this->product->getTypeId(), $type, true);
    }

    /**
     * Updates field in wrapped product
     *
     * @param string $fieldName
     * @param $value
     */
    public function updateField(string $fieldName, $value): void
    {
        $this->product->setData($fieldName, $value);
    }
}
