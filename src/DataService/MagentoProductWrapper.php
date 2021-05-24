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
     * Wrapped product model
     *
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
     * {@inheritDoc}
     */
    public function getSku(): string
    {
        return $this->product->getData('sku');
    }


    /**
     * {@inheritDoc}
     */
    public function getId(): int
    {
        return (int)$this->product->getId();
    }

    /**
     * {@inheritDoc}
     */
    public function isType(string ...$type): bool
    {
        return in_array($this->product->getTypeId(), $type, true);
    }

    /**
     * {@inheritDoc}
     */
    public function updateField(string $fieldName, $value): void
    {
        $this->product->setData($fieldName, $value);
    }
}
