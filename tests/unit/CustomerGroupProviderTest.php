<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use EcomDev\Magento2TestEssentials\ObjectManager;
use EcomDev\ProductDataPreLoader\DataService\SessionCustomerGroupProvider;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Session\SessionStartChecker;
use Magento\Framework\Session\StorageInterface;
use PHPUnit\Framework\TestCase;

/**
 * Customer group provider test case
 */
class CustomerGroupProviderTest extends TestCase
{
    private $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = ObjectManager::new()
            ->withObject(SessionStartChecker::class, new SessionStartChecker(false));
    }

    /** @test */
    public function returnsNonLoggedInCustomerGroupWhenSessionIsNotStarted()
    {
        $this->objectManager = $this->objectManager
            ->withObject(SessionStartChecker::class, new SessionStartChecker(true));

        $provider = $this->createProviderWithSessionStub(function () {
            return 99;
        });

        $this->assertEquals(0, $provider->getCustomerGroupId());
    }

    /** @test */
    public function returnsCustomerGroupFromSessionObject()
    {
        $provider = $this->createProviderWithSessionStub(function () {
            return 10;
        });

        $this->assertEquals(10, $provider->getCustomerGroupId());
    }

    /** @test */
    public function returnsNonLoggedInGroupOnNotFoundException()
    {
        $provider = $this->createProviderWithSessionStub(function () {
            throw new NoSuchEntityException();
        });

        $this->assertEquals(0, $provider->getCustomerGroupId());
    }

    /** @test */
    public function returnsNonLoggedInGroupOnLocalizedException()
    {
        $provider = $this->createProviderWithSessionStub(function () {
            throw new LocalizedException(__('Test'));
        });

        $this->assertEquals(0, $provider->getCustomerGroupId());
    }


    public function createProviderWithSessionStub(callable $groupIdStub): SessionCustomerGroupProvider
    {
        $session = new class($groupIdStub) extends Session {
            private $stub;

            public function __construct($stub)
            {
                $this->stub = $stub;
            }

            public function getCustomerGroupId()
            {
                return ($this->stub)();
            }
        };

        return $this->objectManager->withObject(Session::class, $session)
            ->create(SessionCustomerGroupProvider::class);
    }
}
