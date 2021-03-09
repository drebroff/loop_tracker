<?php
declare(strict_types=1);

namespace Loop\Tracker\Api\Data;

interface ItemsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Items list.
     * @return \Loop\Tracker\Api\Data\ItemsInterface[]
     */
    public function getItems();

    /**
     * Set sku list.
     * @param \Loop\Tracker\Api\Data\ItemsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

