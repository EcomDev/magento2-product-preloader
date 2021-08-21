<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\Magento2TestEssentials\ObjectManager;
use EcomDev\Magento2TestEssentials\Store\Store;
use EcomDev\Magento2TestEssentials\Store\StoreManager;
use EcomDev\ProductDataPreLoader\DataService\CustomerGroupProvider;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilterFactory;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Scope filter from shopping cart
 */
class CartScopeFilterTest extends TestCase
{
    /** @var ScopeFilterFactory */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new ScopeFilterFactory(
            ObjectManager::new()
                ->withObject(CustomerGroupProvider::class, FakeCustomerGroupProvider::create(5))
                ->withObject(
                    StoreManagerInterface::class,
                    StoreManager::new()
                        ->withStore(Store::new(1, 'one')->withWebsite(10, 100))
                        ->withStore(Store::new(2, 'two')->withWebsite(20, 200))
                )
        );
    }

    /** @test */
    public function takesWebsiteFromShoppingCartStoreId()
    {
        $scopeFilter = $this->factory->createFromCart(FakeShoppingCart::fromData(['store_id' => 1]));
        $this->assertEquals(10, $scopeFilter->getWebsiteId());
    }

    /** @test */
    public function defaultsToAnonymousCustomerGroup()
    {
        $scopeFilter = $this->factory->createFromCart(FakeShoppingCart::fromData([]));
        $this->assertEquals(0, $scopeFilter->getCustomerGroupId());
    }

    /** @test */
    public function usesCustomerGroupFromCustomerInShoppingCart()
    {
        $scopeFilter = $this->factory->createFromCart(FakeShoppingCart::fromData([], ['group_id' => 3]));
        $this->assertEquals(3, $scopeFilter->getCustomerGroupId());
    }

    /** @test */
    public function returnsStoreIdFromShoppingCart()
    {
        $scopeFilter = $this->factory->createFromCart(FakeShoppingCart::fromData(['store_id' => '2']));
        $this->assertEquals(2, $scopeFilter->getStoreId());
    }
}
