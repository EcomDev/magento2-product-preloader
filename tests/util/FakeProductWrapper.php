<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\ProductDataPreLoader\DataService\ProductWrapper;
use Magento\Catalog\Model\Product\Type;

/**
 * Product wrapper for testing
 */
class FakeProductWrapper implements ProductWrapper
{
    private $sku;
    private $identifier;
    private $type;

    private function __construct(string $sku, int $identifier, string $type)
    {
        $this->sku = $sku;
        $this->identifier = $identifier;
        $this->type = $type;
    }

    public static function create(string $sku, int $identifier = 0, string $type = Type::TYPE_SIMPLE): self
    {
        return new self($sku, $identifier, $type);
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getId(): int
    {
        return $this->identifier;
    }

    public function isType(string ...$type): bool
    {
        return in_array($this->type, $type, true);
    }

    public function updateField(string $fieldName, $value): void
    {
        // Does nothing
    }
}
