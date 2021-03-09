<?php
declare(strict_types=1);

namespace Loop\Tracker\Api\Data;

interface ItemsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CREATED_AT = 'created_at';
    const ITEMS_ID = 'items_id';
    const TRACKING_CODE = 'tracking_code';
    const SKU = 'sku';
    const TRACKING_MESSAGE = 'tracking_message';

    /**
     * Get items_id
     * @return string|null
     */
    public function getItemsId();

    /**
     * Set items_id
     * @param string $itemsId
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setItemsId($itemsId);

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setSku($sku);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Loop\Tracker\Api\Data\ItemsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Loop\Tracker\Api\Data\ItemsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Loop\Tracker\Api\Data\ItemsExtensionInterface $extensionAttributes
    );

    /**
     * Get tracking_code
     * @return string|null
     */
    public function getTrackingCode();

    /**
     * Set tracking_code
     * @param string $trackingCode
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setTrackingCode($trackingCode);

    /**
     * Get tracking_message
     * @return string|null
     */
    public function getTrackingMessage();

    /**
     * Set tracking_message
     * @param string $trackingMessage
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setTrackingMessage($trackingMessage);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     */
    public function setCreatedAt($createdAt);
}

