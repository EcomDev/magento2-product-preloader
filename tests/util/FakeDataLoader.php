<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\ProductDataPreLoader\DataService\DataLoader;
use EcomDev\ProductDataPreLoader\DataService\ProductWrapper;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilter;

/**
 * Fake data loader
 */
class FakeDataLoader implements DataLoader
{
    /**
     * Allowed types for data loader
     *
     * @var string[]
     */
    private $allowedTypes;

    /**
     * Provider of loaded data
     *
     * @var callable|null
     */
    private $loader;

    private function __construct(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * Creates a loader which responds to this type of loaders
     *
     * @param string ...$allowedTypes
     *
     * @return self
     */
    public static function create(string...$allowedTypes): self
    {
        return new self($allowedTypes);
    }

    /**
     * Specifies loader on copied data load
     *
     * @param callable $callback
     *
     * @return self
     */
    public function withLoader(callable $callback): self
    {
        $loader = clone $this;
        $loader->loader = $callback;
        return $loader;
    }

    /**
     * Loads data from callback or returns empty array if loader is not specified
     *
     * @param ScopeFilter $filter
     * @param array $products
     *
     * @return array
     */
    public function load(ScopeFilter $filter, array $products): array
    {
        if (isset($this->loader)) {
            return ($this->loader)($filter, $products);
        }

        return [];
    }

    /**
     * Checks if this loader is applicable
     *
     * @param string $type
     *
     * @return bool
     */
    public function isApplicable(string $type): bool
    {
        return in_array($type, $this->allowedTypes, true);
    }
}
