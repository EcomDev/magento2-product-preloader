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
use Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

class ProductLimitationScopeFilterTest extends TestCase
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
    public function defaultsCustomerGroupToOneProvidedByCustomerGroupProvider()
    {
        $scopeFilter = $this->factory->createFromLimitation(1, new ProductLimitation());
        $this->assertEquals(
            5,
            $scopeFilter->getCustomerGroupId()
        );
    }

    /** @test */
    public function defaultsWebsiteIdToAssociatedWithStore()
    {
        $scopeFilter = $this->factory->createFromLimitation(1, new ProductLimitation());

        $this->assertEquals(
            10,
            $scopeFilter->getWebsiteId()
        );
    }

    /** @test */
    public function returnsStoreIdFromArguments()
    {
        $scopeFilter = $this->factory->createFromLimitation(2, new ProductLimitation());

        $this->assertEquals(
            2,
            $scopeFilter->getStoreId()
        );
    }

    /** @test */
    public function overridesWebsiteIdFromLimitationWhenIndexIsUsed()
    {
        $productLimitation = new ProductLimitation();
        $productLimitation['website_id'] = 9;
        $productLimitation['customer_group_id'] = 0;
        $productLimitation['use_price_index'] = true;

        $scopeFilter = $this->factory->createFromLimitation(2, $productLimitation);

        $this->assertEquals(
            9,
            $scopeFilter->getWebsiteId()
        );
    }

    /** @test */
    public function notifiesItDoesNotHaveCustomerGroupWhenCustomerGroupDefaultsToProvider()
    {
        $scopeFilter = $this->factory->createFromLimitation(2, new ProductLimitation());
        $this->assertEquals(false, $scopeFilter->hasCustomerGroupId());
    }

    /** @test */
    public function notifiesItHasCustomerGroupWhenUsingPriceIndex()
    {
         $scopeFilter = $this->factory->createFromLimitation(
             2,
             $this->createLimitation([
                'website_id' => 9,
                'customer_group_id' => 2,
                'use_price_index' => true
             ])
         );

        $this->assertEquals(true, $scopeFilter->hasCustomerGroupId());
    }

    /** @test */
    public function returnsCustomerGroupFromProductLimitation()
    {
        $scopeFilter = $this->factory->createFromLimitation(
            2,
            $this->createLimitation([
                'website_id' => 9,
                'customer_group_id' => 99,
                'use_price_index' => true
            ])
        );

        $this->assertEquals(99, $scopeFilter->getCustomerGroupId());
    }

    /** @test */
    public function supportsWrongDataDataFromLimitation()
    {
        $scopeFilter = $this->factory->createFromLimitation(
            2,
            $this->createLimitation([
                'website_id' => '9',
                'customer_group_id' => '99',
                'use_price_index' => true
            ])
        );

        $this->assertEquals(
            [9, 99],
            [$scopeFilter->getWebsiteId(), $scopeFilter->getCustomerGroupId()]
        );
    }

    private function createLimitation(iterable $data = []): ProductLimitation
    {
        $productLimitation = new ProductLimitation();

        foreach ($data as $key => $value) {
            $productLimitation[$key] = $value;
        }

        return $productLimitation;
    }
}
