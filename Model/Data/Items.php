<?php
declare(strict_types=1);

namespace Loop\Tracker\Model\Data;

use Loop\Tracker\Api\Data\ItemsInterface;

class Items extends \Magento\Framework\Api\AbstractExtensibleObject implements ItemsInterface
{

    /**
     * Get items_id
     * @return string|null
     */
    public function getItemsId()
    {
        return $this->_get(self::ITEMS_ID);
    }

    /**
     * Set items_id
     * @param string $itemsId
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setItemsId($itemsId)
    {
        return $this->setData(self::ITEMS_ID, $itemsId);
    }

    /**
     * Get sku
     * @return string|null
     */
    public function getSku()
    {
        return $this->_get(self::SKU);
    }

    /**
     * Set sku
     * @param string $sku
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Loop\Tracker\Api\Data\ItemsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Loop\Tracker\Api\Data\ItemsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Loop\Tracker\Api\Data\ItemsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get tracking_code
     * @return string|null
     */
    public function getTrackingCode()
    {
        return $this->_get(self::TRACKING_CODE);
    }

    /**
     * Set tracking_code
     * @param string $trackingCode
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setTrackingCode($trackingCode)
    {
        return $this->setData(self::TRACKING_CODE, $trackingCode);
    }

    /**
     * Get tracking_message
     * @return string|null
     */
    public function getTrackingMessage()
    {
        return $this->_get(self::TRACKING_MESSAGE);
    }

    /**
     * Set tracking_message
     * @param string $trackingMessage
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setTrackingMessage($trackingMessage)
    {
        return $this->setData(self::TRACKING_MESSAGE, $trackingMessage);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}

