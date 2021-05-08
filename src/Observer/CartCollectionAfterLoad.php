<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Observer;

use EcomDev\ProductDataPreLoader\DataService\DataLoader;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilterFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\ResourceModel\Quote\Item\Collection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Executes pre-loaders when product collection in the shopping cart gets loaded
 */
class CartCollectionAfterLoad implements ObserverInterface
{
    /**
     * Observer to pass data into
     *
     * @var ListCollectionAfterLoad
     */
    private $productObserver;

    /**
     * Cart instance
     *
     * @var CartInterface|null
     */
    private $cart;

    /**
     * Filter factory
     *
     * @var ScopeFilterFactory
     */
    private $filterFactory;

    /**
     * CartCollectionAfterLoad constructor.
     *
     * @param ListCollectionAfterLoad $productObserver
     * @param ScopeFilterFactory $filterFactory
     */
    public function __construct(ListCollectionAfterLoad $productObserver, ScopeFilterFactory $filterFactory)
    {
        $this->productObserver = $productObserver;
        $this->filterFactory = $filterFactory;
    }

    /**
     * Set cart for future scope filter creation
     *
     * @param CartInterface $cart
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Stores scope filter into product observer collection
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Collection $collection */
        $collection = $observer->getData('collection');

        if (!$collection instanceof Collection) {
            return;
        }

        if ($this->cart) {
            $this->productObserver->setScopeFilterAndType(
                DataLoader::TYPE_CART,
                $this->filterFactory->createFromCart($this->cart)
            );
        }
    }
}
