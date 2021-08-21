<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Observer;

use EcomDev\ProductDataPreLoader\DataService\DataLoader;
use EcomDev\ProductDataPreLoader\DataService\LoadService;
use EcomDev\ProductDataPreLoader\DataService\MagentoProductWrapperFactory;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilterFactory;
use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Observer\AddInventoryDataObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Executes pre-loaders when product collection in the shopping cart gets loaded
 */
class ProductAfterLoad implements ObserverInterface
{
    /**
     * Loader service
     *
     * @var LoadService
     */
    private $loadService;

    /**
     * Scope filter
     *
     * @var ScopeFilterFactory
     */
    private $filterFactory;

    /**
     * Adapter factory
     *
     * @var MagentoProductWrapperFactory
     */
    private $productAdapterFactory;


    public function __construct(
        LoadService $loadService,
        ScopeFilterFactory $filterFactory,
        MagentoProductWrapperFactory $productAdapterFactory
    ) {
        $this->loadService = $loadService;
        $this->filterFactory = $filterFactory;
        $this->productAdapterFactory = $productAdapterFactory;
    }

    /**
     * Adds our observer before stock observer execution
     *
     * @param AddInventoryDataObserver $inventoryObserver
     * @param Observer $observer
     *
     * @return array
     */
    public function beforeExecute($inventoryObserver, Observer $observer)
    {
        $this->execute($observer);
        return [$observer];
    }

    /**
     * Pre-loads data for product that is loaded in separately
     */
    public function execute(Observer $observer)
    {
        /* @var Product $product */
        $product = $observer->getData('product');

        if (empty($product->getId())) {
            return;
        }

        $scope = $this->filterFactory->createFromStore($product->getStoreId());
        $type = DataLoader::TYPE_CART;

        $adapter = $this->productAdapterFactory->create($product);

        $productInfo = [
            $product->getId() => $adapter
        ];

        $this->loadService->load(
            $type,
            $scope,
            $productInfo
        );
    }
}
