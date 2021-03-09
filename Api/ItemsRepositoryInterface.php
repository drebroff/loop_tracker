<?php
declare(strict_types=1);

namespace Loop\Tracker\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ItemsRepositoryInterface
{

    /**
     * Save Items
     * @param \Loop\Tracker\Api\Data\ItemsInterface $items
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Loop\Tracker\Api\Data\ItemsInterface $items
    );

    /**
     * Retrieve Items
     * @param string $itemsId
     * @return \Loop\Tracker\Api\Data\ItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($itemsId);

    /**
     * Retrieve Items matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Loop\Tracker\Api\Data\ItemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Items
     * @param \Loop\Tracker\Api\Data\ItemsInterface $items
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Loop\Tracker\Api\Data\ItemsInterface $items
    );

    /**
     * Delete Items by ID
     * @param string $itemsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($itemsId);
}

