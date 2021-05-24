<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Observer;

use EcomDev\ProductDataPreLoader\DataService\DataLoader;
use EcomDev\ProductDataPreLoader\DataService\LoadService;
use EcomDev\ProductDataPreLoader\DataService\MagentoProductWrapperFactory;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilter;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilterFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Executes pre-loaders when product collection in the list gets loaded
 */
class ListCollectionAfterLoad implements ObserverInterface
{
    /**
     * Override of current scope filter
     *
     * @var ScopeFilter|null
     */
    private $currentScope;

    /**
     * Override of current type of data to load
     *
     * @var string|null
     */
    private $currentType;

    /**
     * Load service
     *
     * @var LoadService
     */
    private $loadService;

    /**
     * Factory for creating filters
     *
     * @var ScopeFilterFactory
     */
    private $filterFactory;

    /**
     * Factory for creating product adapters
     *
     * @var MagentoProductWrapperFactory
     */
    private $adapterFactory;

    /**
     * ListCollectionAfterLoad constructor.
     *
     * @param LoadService $loadService
     * @param ScopeFilterFactory $filterFactory
     * @param MagentoProductWrapperFactory $adapterFactory
     */
    public function __construct(
        LoadService $loadService,
        ScopeFilterFactory $filterFactory,
        MagentoProductWrapperFactory $adapterFactory
    ) {
        $this->loadService = $loadService;
        $this->filterFactory = $filterFactory;
        $this->adapterFactory = $adapterFactory;
    }

    /**
     * Set current scope filter for type
     *
     * @param string $type
     * @param ScopeFilter $filter
     */
    public function setScopeFilterAndType(string $type, ScopeFilter $filter)
    {
        $this->currentType = $type;
        $this->currentScope = $filter;
    }

    /**
     * Pre-loads data for product that is loaded in the product listings
     */
    public function execute(Observer $observer)
    {
        /* @var Collection $collection */
        $collection = $observer->getData('collection');

        $productInfo = [];
        /* @var Product $product */
        foreach ($collection->getItems() as $product) {
            $productInfo[(int)$product->getId()] = $this->adapterFactory->create($product);
        }

        $type = DataLoader::TYPE_OTHER;
        $scope = $this->filterFactory->createFromLimitation(
            (int)$collection->getStoreId(),
            $collection->getLimitationFilters()
        );

        if ($collection->getLimitationFilters()->isUsingPriceIndex()) {
            $type = DataLoader::TYPE_LIST;
        }

        if ($this->currentScope && $this->currentType) {
            $type = $this->currentType;
            $scope = $this->currentScope;
            $this->currentScope = null;
            $this->currentType = null;
        }

        $this->loadService->load($type, $scope, $productInfo);
    }
}
