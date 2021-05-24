<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 */
declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader\DataService;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Session\SessionStartChecker;
use Magento\Customer\Model\Session;

/**
 * Customer group provider for dynamic resolution of it
 */
class CustomerGroupProvider
{
    /**
     * Customer session instance
     *
     * @var Session
     */
    private $customerSession;

    /**
     * Session availability checker
     *
     * @var SessionStartChecker
     */
    private $sessionChecker;

    /**
     * CustomerGroupProvider constructor.
     *
     * @param Session $customerSession
     * @param SessionStartChecker $sessionChecker
     */
    public function __construct(Session $customerSession, SessionStartChecker $sessionChecker)
    {
        $this->customerSession = $customerSession;
        $this->sessionChecker = $sessionChecker;
    }

    /**
     * Return current customer group
     *
     * @return int
     */
    public function getCustomerGroupId(): int
    {
        if ($this->sessionChecker->check()) {
            try {
                return $this->customerSession->getCustomerGroupId();
            } catch (NoSuchEntityException | LocalizedException $e) {
                return 0;
            }
        }

        return 0;
    }
}
