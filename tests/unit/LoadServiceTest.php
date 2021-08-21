<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\ProductDataPreLoader\DataService\LoadService;
use EcomDev\ProductDataPreLoader\DataService\ScopeFilter;
use PHPUnit\Framework\TestCase;

/**
 * Test case for store based LoadService
 */
class LoadServiceTest extends TestCase
{
    private function createService(array $loaders)
    {
        return new LoadService($loaders);
    }

    /** @test */
    public function loadsDataWhenTypeIsMatching()
    {
        $loader = $this->createService([
            'one' => FakeDataLoader::create('cart')
        ]);

        $loader->load('cart', new FakeScopeFilter(1, 1), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $this->assertEquals(true, $loader->has(1, 'one'));
    }

    /** @test */
    public function skipsDataWhenLoaderIsDifferent()
    {
        $loader = $this->createService([
            'not_applicable' => FakeDataLoader::create('catalog')
        ]);

        $loader->load('cart', new FakeScopeFilter(1, 1), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $this->assertEquals(false, $loader->has(1, 'not_applicable'));
    }

    /** @test */
    public function mapsSkuToIdWhenNoLoadersAreSpecified()
    {
        $loader = $this->createService([]);

        $loader->load('catalog', new FakeScopeFilter(2, 2), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $this->assertEquals(
            [1, 2, null],
            [$loader->skuToId('s_one'), $loader->skuToId('s_two'), $loader->skuToId('s_three')]
        );
    }

    /** @test */
    public function loadsDataFromValidDataProvider()
    {
        $loader = $this->createService([
            'valid' => FakeDataLoader::create('catalog')
                ->withLoader(function (ScopeFilter $filter, $products) {
                    $result = [];
                    foreach ($products as $product) {
                        $result[$product->getId()]['attribute'] = 'one';
                    }
                    return $result;
                })
        ]);

        $loader->load('catalog', new FakeScopeFilter(1, 1), [
            4 => FakeProductWrapper::create('s_four', 4),
            5 => FakeProductWrapper::create('s_five', 5),
        ]);

        $this->assertEquals(['attribute' => 'one'], $loader->get(4, 'valid'));
    }

    /** @test */
    public function doesNotOverrideValueAfterOriginalLoad()
    {
        $loader = $this->createService([
            'increment' => FakeDataLoader::create('catalog')
                ->withLoader(function (ScopeFilter $filter, $products) {
                    $result = [];
                    static $increment = 0;
                    $increment ++;
                    foreach ($products as $product) {
                        $result[$product->getId()]['counter'] = $increment;
                    }
                    return $result;
                })
        ]);

        $loader->load('catalog', new FakeScopeFilter(1, 1), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $loader->load('catalog', new FakeScopeFilter(1, 1), [
            2 => FakeProductWrapper::create('s_two', 2),
            3 => FakeProductWrapper::create('s_three', 3),
        ]);

        $this->assertEquals(['counter' => 1], $loader->get(2, 'increment'));
    }

    /** @test */
    public function loadsDataOnlyOnceForTheSameProducts()
    {
        $loader = $this->createService([
            'unique' => FakeDataLoader::create('catalog')
                ->withLoader(function (ScopeFilter $filter, $products) {
                    $result = [];
                    static $increment = 0;
                    foreach ($products as $product) {
                        $result[$product->getId()]['id'] = ++$increment;
                    }
                    return $result;
                })
        ]);

        $loader->load('catalog', new FakeScopeFilter(1, 1), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $loader->load('catalog', new FakeScopeFilter(1, 1), [
            1 => FakeProductWrapper::create('s_one', 1),
            2 => FakeProductWrapper::create('s_two', 2),
        ]);

        $this->assertEquals(
            [
                ['id' => 1],
                ['id' => 2]
            ],
            [
                $loader->get(1, 'unique'),
                $loader->get(2, 'unique')
            ]
        );
    }
}
