<?php

namespace EcomDev\ProductDataPreLoader\DataService;

use Magento\Catalog\Model\Product;
use Magento\Framework\ObjectManagerInterface;

/**
 * Factory for a product wrapper
 */
class MagentoProductWrapperFactory
{
    /**
     * Object manager instance to create wrappers around product
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * MagentoProductWrapperFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Crates a product wrapper instance
     *
     * @param Product $product
     */
    public function create(Product $product): ProductWrapper
    {
        return $this->objectManager->create(MagentoProductWrapper::class, ['product' => $product]);
    }
}
