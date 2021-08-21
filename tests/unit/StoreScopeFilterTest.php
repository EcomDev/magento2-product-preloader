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
 * Test case for store based ScopeFilter
 */
class StoreScopeFilterTest extends TestCase
{
    /** @var ScopeFilterFactory */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new ScopeFilterFactory(
            ObjectManager::new()
                ->withObject(CustomerGroupProvider::class, FakeCustomerGroupProvider::create(11))
                ->withObject(
                    StoreManagerInterface::class,
                    StoreManager::new()
                        ->withStore(Store::new(1, 'one')->withWebsite(10, 99))
                        ->withStore(Store::new(2, 'two')->withWebsite(20, 99))
                )
        );
    }

    /** @test */
    public function usesWebsiteFromAssignedStore()
    {
        $scopeFilter = $this->factory->createFromStore(1);
        $this->assertEquals(10, $scopeFilter->getWebsiteId());
    }
}
