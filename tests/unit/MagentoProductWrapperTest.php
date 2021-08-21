<?php

namespace EcomDev\ProductDataPreLoader;

use EcomDev\Magento2TestEssentials\ObjectManager;
use EcomDev\ProductDataPreLoader\DataService\MagentoProductWrapperFactory;
use Magento\Catalog\Model\Product;
use PHPUnit\Framework\TestCase;

/**
 * Tests for product wrapper
 *
 */
class MagentoProductWrapperTest extends TestCase
{
    /* @var MagentoProductWrapperFactory */
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new MagentoProductWrapperFactory(ObjectManager::new());
    }

    /** @test */
    public function verifiesThatSimpleProductIsNotAConfigurable()
    {
        $item = $this->factory->create($this->createProduct(['type_id' => 'simple']));

        $this->assertFalse($item->isType('configurable'));
    }

    /** @test */
    public function verifiesThatProductMatchesAtLeastOneProductTypeInArgumentList()
    {
        $item = $this->factory->create($this->createProduct(['type_id' => 'valid_type']));

        $this->assertTrue($item->isType('simple', 'virtual', 'valid_type', 'another_type'));
    }

    /** @test */
    public function returnsSkuFromWrappedProduct()
    {
        $item = $this->factory->create($this->createProduct(['sku' => 'SKU10']));

        $this->assertEquals('SKU10', $item->getSku());
    }

    /** @test */
    public function returnsIdFromWrappedProduct()
    {
        $item = $this->factory->create($this->createProduct(['entity_id' => '123']));

        $this->assertEquals(123, $item->getId());
    }

    /** @test */
    public function updatesFieldsInProductDataStorage()
    {
        $product = $this->createProduct(['some_data' => 1]);
        $item = $this->factory->create($product);

        $item->updateField('another_field', 'value1');
        $item->updateField('final_field', 'value2');

        $this->assertEquals(
            [
                'some_data' => 1,
                'another_field' => 'value1',
                'final_field' => 'value2'
            ],
            $product->getData()
        );
    }

    /**
     * Crates a new product for testing
     *
     * @param array $data
     *
     * @return Product
     */
    private function createProduct(array $data = []): Product
    {
        /* @var Product $product */
        $product = ObjectManager::new()->get(Product::class);
        $product->setData($data);

        return $product;
    }
}
