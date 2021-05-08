<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;


use Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;
use Magento\Framework\ObjectManagerInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * Scope filter factory
 *
 */
class ScopeFilterFactory
{
    /**
     * Object manager to instantiate scope filter
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * ScopeFilterFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create scope filter from shopping cart
     *
     * @param CartInterface $cart
     * @return MagentoScopeFilter
     */
    public function createFromCart(CartInterface $cart): MagentoScopeFilter
    {
        return $this->objectManager->create(MagentoScopeFilter::class, [
            'options' => [
                'store_id' => $cart->getStoreId(),
                'customer_group_id' => $cart->getCustomerIsGuest() ? 0 : $cart->getCustomer()->getGroupId()
            ]
        ]);
    }

    /**
     * Create scope filter from store identifier
     *
     * @param int $storeId
     * @return MagentoScopeFilter
     */
    public function createFromStore(int $storeId): MagentoScopeFilter
    {
        return $this->objectManager->create(MagentoScopeFilter::class, [
            'options' => [
                'store_id' => $storeId
            ]
        ]);
    }

    /**
     * Create scope filter from product limitation object
     *
     * @param int $storeId
     * @param ProductLimitation $productLimitation
     * @return MagentoScopeFilter
     */
    public function createFromLimitation(int $storeId, ProductLimitation $productLimitation): MagentoScopeFilter
    {
        $options = [
            'store_id' => $storeId,
        ];

        if ($productLimitation->isUsingPriceIndex()) {
            $options['website_id'] = $productLimitation->getWebsiteId();
            $options['customer_group_id'] = $productLimitation->getCustomerGroupId();
        }

        return $this->objectManager->create(MagentoScopeFilter::class, [
            'options' => $options
        ]);
    }
}
