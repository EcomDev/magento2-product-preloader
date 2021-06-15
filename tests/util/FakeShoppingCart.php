<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;


use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CurrencyInterface;

class FakeShoppingCart implements CartInterface
{
    /**
     * Shopping cart data
     *
     * @var array
     */
    private $data = [];

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Creates shopping cart
     *
     * @param array $data
     * @param array $customerData
     *
     * @return self
     */
    public static function fromData(array $data, array $customerData = []): self
    {
        if ($customerData) {
            $data['customer'] = FakeCustomer::fromData($customerData);
        }

        return new self($data);
    }

    /* @inheritDoc */
    public function getId()
    {
        return $this->data['id'] ?? null;
    }

    /* @inheritDoc */
    public function setId($id)
    {
        $this->data['id'] = $id;
        return $this;
    }

    /* @inheritDoc */
    public function getCreatedAt()
    {
        return $this->data['created_at'] ?? null;
    }

    /* @inheritDoc */
    public function setCreatedAt($createdAt)
    {
        $this->data['created_at'] = $createdAt;
        return $this;
    }

    /* @inheritDoc */
    public function getUpdatedAt()
    {
        return $this->data['updated_at'] ?? null;
    }

    /* @inheritDoc */
    public function setUpdatedAt($updatedAt)
    {
        $this->data['updated_at'] = $updatedAt;
        return $this;
    }

    /* @inheritDoc */
    public function getConvertedAt()
    {
        return $this->data['converted_at'] ?? null;
    }

    /* @inheritDoc */
    public function setConvertedAt($convertedAt)
    {
        $this->data['converted_at'] = $convertedAt;
        return $this;
    }

    /* @inheritDoc */
    public function getIsActive()
    {
        return $this->data['is_active'] ?? null;
    }

    /* @inheritDoc */
    public function setIsActive($isActive)
    {
        $this->data['is_active'] = $isActive;
        return $this;
    }

    /* @inheritDoc */
    public function getIsVirtual()
    {
        return $this->data['is_virtual'] ?? false;
    }

    /* @inheritDoc */
    public function getItems()
    {
        return $this->data['items'] ?? null;
    }

    /* @inheritDoc */
    public function setItems(array $items = null)
    {
        $this->data['items'] = $items;
        return $this;
    }

    /* @inheritDoc */
    public function getItemsCount()
    {
        return $this->data['items_count'] ?? null;
    }

    /* @inheritDoc */
    public function setItemsCount($itemsCount)
    {
        $this->data['items_count'] = $itemsCount;
        return $this;
    }

    /* @inheritDoc */
    public function getItemsQty()
    {
        return $this->data['items_qty'] ?? null;
    }

    /* @inheritDoc */
    public function setItemsQty($itemQty)
    {
        $this->data['items_qty'] = $itemQty;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomer()
    {
        return $this->data['customer'];
    }

    /* @inheritDoc */
    public function setCustomer(\Magento\Customer\Api\Data\CustomerInterface $customer = null)
    {
        $this->data['customer'] = $customer;
        return $this;
    }

    /* @inheritDoc */
    public function getBillingAddress()
    {
        return $this->data['billing_address'] ?? null;
    }

    /* @inheritDoc */
    public function setBillingAddress(\Magento\Quote\Api\Data\AddressInterface $billingAddress = null)
    {
        $this->data['billing_address'] = $billingAddress;
        return $this;
    }

    /* @inheritDoc */
    public function getReservedOrderId()
    {
        return $this->data['reserved_order_id'] ?? null;
    }

    /* @inheritDoc */
    public function setReservedOrderId($reservedOrderId)
    {
        $this->data['reserved_order_id'] = $reservedOrderId;
        return $this;
    }

    /* @inheritDoc */
    public function getOrigOrderId()
    {
        return $this->data['orig_order_id'] ?? null;
    }

    /* @inheritDoc */
    public function setOrigOrderId($origOrderId)
    {
        $this->data['orig_order_id'] = $origOrderId;
        return $this;
    }

    /* @inheritDoc */
    public function getCurrency()
    {
        return $this->data['currency'] ?? null;
    }

    /* @inheritDoc */
    public function setCurrency(CurrencyInterface $currency = null)
    {
        $this->data['currency'] = $currency;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomerIsGuest()
    {
        return $this->data['customer_is_guest'] ?? null;
    }

    /* @inheritDoc */
    public function setCustomerIsGuest($customerIsGuest)
    {
        $this->data['customer_is_guest'] = $customerIsGuest;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomerNote()
    {
        return $this->data['customer_note'] ?? null;
    }

    /* @inheritDoc */
    public function setCustomerNote($customerNote)
    {
        $this->data['customer_note'] = $customerNote;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomerNoteNotify()
    {
        return $this->data['customer_note_notify'] ?? null;
    }

    /* @inheritDoc */
    public function setCustomerNoteNotify($customerNoteNotify)
    {
        $this->data['customer_note_notify'] = $customerNoteNotify;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomerTaxClassId()
    {
        return $this->data['customer_tax_class_id'] ?? null;
    }

    /* @inheritDoc */
    public function setCustomerTaxClassId($customerTaxClassId)
    {
        $this->data['customer_tax_class_id'] = $customerTaxClassId;
        return $this;
    }

    /* @inheritDoc */
    public function getStoreId()
    {
        return $this->data['store_id'] ?? null;
    }

    /* @inheritDoc */
    public function setStoreId($storeId)
    {
        $this->data['store_id'] = $storeId;
        return $this;
    }

    /* @inheritDoc */
    public function getExtensionAttributes()
    {
        return $this->data['extension_attributes'] ?? null;
    }

    /* @inheritDoc */
    public function setExtensionAttributes(\Magento\Quote\Api\Data\CartExtensionInterface $extensionAttributes)
    {
        $this->data['extension_attributes'] = $extensionAttributes;
        return $this;
    }
}
