<?php
/**
 * Copyright © EcomDev B.V. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace EcomDev\ProductDataPreLoader;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Fake customer implementation for session management
 */
class FakeCustomer implements CustomerInterface
{
    /**
     * Customer data
     *
     * @var array
     */
    private $data = [];

    /**
     * FakeCustomer constructor.
     *
     * @param array $data
     */
    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Crates customer from data
     *
     * @param array $data
     *
     * @return FakeCustomer
     */
    public static function fromData(array $data): self
    {
        return new self($data);
    }

    /* @inheritDoc */
    public function getCustomAttribute($attributeCode)
    {
        return $this->data[$attributeCode] ?? null;
    }

    /* @inheritDoc */
    public function setCustomAttribute($attributeCode, $attributeValue)
    {
        $this->data[$attributeCode] = $attributeValue;
        return $this;
    }

    /* @inheritDoc */
    public function getCustomAttributes()
    {
        return $this->data;
    }

    /* @inheritDoc */
    public function setCustomAttributes(array $attributes)
    {
        $this->data = $attributes;
        return $this;
    }

    /* @inheritDoc */
    public function getId()
    {
        return $this->data['id'] ?? 0;
    }

    /* @inheritDoc */
    public function setId($customerId)
    {
        $this->data['id'] = $customerId;
        return $this;
    }

    /* @inheritDoc */
    public function getGroupId()
    {
        return $this->data['group_id'] ?? 0;
    }

    /* @inheritDoc */
    public function setGroupId($groupId)
    {
        $this->data['group_id'] = (int)$groupId;
        return $this;
    }

    /* @inheritDoc */
    public function getDefaultBilling()
    {
        return $this->data['default_billing'] ?? null;
    }

    /* @inheritDoc */
    public function setDefaultBilling($defaultBilling)
    {
        $this->data['default_billing'] = $defaultBilling;
        return $this;
    }

    /* @inheritDoc */
    public function getDefaultShipping()
    {
        return $this->data['default_shipping'] ?? null;
    }

    /* @inheritDoc */
    public function setDefaultShipping($defaultShipping)
    {
        $this->data['default_shipping'] = $defaultShipping;
        return $this;
    }

    /* @inheritDoc */
    public function getConfirmation()
    {
        return $this->data['confirmation'] ?? null;
    }

    /* @inheritDoc */
    public function setConfirmation($confirmation)
    {
        $this->data['confirmation'] = $confirmation;
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
    public function getCreatedIn()
    {
        return $this->data['created_in'] ?? null;
    }

    /* @inheritDoc */
    public function setCreatedIn($createdIn)
    {
        $this->data['created_in'] = $createdIn;
        return $this;
    }

    /* @inheritDoc */
    public function getDob()
    {
        return $this->data['dob'] ?? null;
    }

    /* @inheritDoc */
    public function setDob($dob)
    {
        $this->data['dob'] = $dob;
        return $this;
    }

    /* @inheritDoc */
    public function getEmail()
    {
        return $this->data['email'] ?? null;
    }

    /* @inheritDoc */
    public function setEmail($email)
    {
        $this->data['email'] = $email;
        return $this;
    }

    /* @inheritDoc */
    public function getFirstname()
    {
        return $this->data['firstname'] ?? null;
    }

    /* @inheritDoc */
    public function setFirstname($firstname)
    {
        $this->data['firstname'] = $firstname;
        return $this;
    }

    /* @inheritDoc */
    public function getLastname()
    {
        return $this->data['lastname'] ?? null;
    }

    /* @inheritDoc */
    public function setLastname($lastname)
    {
        $this->data['lastname'] = $lastname;
        return $this;
    }

    /* @inheritDoc */
    public function getMiddlename()
    {
        return $this->data['middlename'] ?? null;
    }

    /* @inheritDoc */
    public function setMiddlename($middlename)
    {
        $this->data['middlename'] = $middlename;
        return $this;
    }

    /* @inheritDoc */
    public function getPrefix()
    {
        return $this->data['prefix'];
    }

    /* @inheritDoc */
    public function setPrefix($prefix)
    {
        $this->data['prefix'] = $prefix;
        return $this;
    }

    /* @inheritDoc */
    public function getSuffix()
    {
        return $this->data['suffix'] ?? null;
    }

    /* @inheritDoc */
    public function setSuffix($suffix)
    {
        $this->data['suffix'] = $suffix;
        return $this;
    }

    /* @inheritDoc */
    public function getGender()
    {
        return $this->data['gender'] ?? null;
    }

    /* @inheritDoc */
    public function setGender($gender)
    {
        $this->data['gender'] = $gender;
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
    public function getTaxvat()
    {
        return $this->data['taxvat'];
    }

    /* @inheritDoc */
    public function setTaxvat($taxvat)
    {
        $this->data['taxvat'] = $taxvat;
        return $this;
    }

    /* @inheritDoc */
    public function getWebsiteId()
    {
        return $this->data['website_id'];
    }

    /* @inheritDoc */
    public function setWebsiteId($websiteId)
    {
        $this->data['website_id'] = $websiteId;
        return $this;
    }

    /* @inheritDoc */
    public function getAddresses()
    {
        return $this->data['addresses'] ?? null;
    }

    /* @inheritDoc */
    public function setAddresses(array $addresses = null)
    {
        $this->data['addresses'] = $addresses;
        return $this;
    }

    /* @inheritDoc */
    public function getDisableAutoGroupChange()
    {
        return $this->data['disable_auto_group_change'] ?? 0;
    }

    /* @inheritDoc */
    public function setDisableAutoGroupChange($disableAutoGroupChange)
    {
        $this->data['disable_auto_group_change'] = $disableAutoGroupChange;
        return $this;
    }

    /* @inheritDoc */
    public function getExtensionAttributes()
    {
        return $this->data['extension_attributes'] ?? null;
    }

    /* @inheritDoc */
    public function setExtensionAttributes(\Magento\Customer\Api\Data\CustomerExtensionInterface $extensionAttributes)
    {
        $this->data['extension_attributes'] = $extensionAttributes;
        return $this;
    }
}
