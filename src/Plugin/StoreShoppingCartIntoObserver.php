<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\Plugin;

use EcomDev\ProductDataPreLoader\Observer\CartCollectionAfterLoad;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\ResourceModel\Quote\Item\Collection;

/**
 * Stores shopping cart into quote item observer
 */
class StoreShoppingCartIntoObserver
{
    /**
     * Exact functionality
     *
     * @var CartCollectionAfterLoad
     */
    private $itemObserver;

    public function __construct(CartCollectionAfterLoad $itemObserver)
    {
        $this->itemObserver = $itemObserver;
    }

    /**
     * Sets cart from item collection
     *
     * @param Collection $subject
     * @param CartInterface $cart
     *
     * @return CartInterface[]
     */
    public function beforeSetQuote(Collection $subject, CartInterface $cart)
    {
        $this->itemObserver->setCart($cart);
        return [$cart];
    }
}
