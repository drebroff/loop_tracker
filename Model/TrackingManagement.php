<?php
declare(strict_types=1);

namespace Loop\Tracker\Model;

use Loop\Tracker\Model\ItemsRepository;
use Loop\Tracker\Model\Items;
use Magento\Framework\Api\SearchCriteriaInterface;
use Loop\Tracker\Api\Data\ItemsInterfaceFactory;

class TrackingManagement implements \Loop\Tracker\Api\TrackingManagementInterface
{
    /**
     * @var \Loop\Tracker\Model\ItemsRepository
     */
    private $trackingItemsRepository;

    /**
     * @var \Loop\Tracker\Model\Items
     */
    private $trackingItems;

    /**
     * @var ItemsInterfaceFactory
     */
    private $itemsFactory;

    /**
     * @var SearchCriteriaInterface
     */
    private $seachCriteria;

    /**
     * TrackingManagement constructor.
     * @param ItemsInterfaceFactory $_itemsFactory
     * @param SearchCriteriaInterface $_seachCriteria
     * @param \Loop\Tracker\Model\Items $_trackingItems
     * @param \Loop\Tracker\Model\ItemsRepository $_trackingItemsRepository
     */
    public function __construct(
        ItemsInterfaceFactory $_itemsFactory,
        SearchCriteriaInterface $_seachCriteria,
        Items $_trackingItems,
        ItemsRepository $_trackingItemsRepository
    ) {
        $this->itemsFactory = $_itemsFactory;
        $this->seachCriteria = $_seachCriteria;
        $this->trackingItems = $_trackingItems;
        $this->trackingItemsRepository = $_trackingItemsRepository;
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTracking()
    {
        // @todo Make it through factory.
        $itemsData = $this->trackingItems->getCollection()->getData();
        $items = ['items'=> $itemsData];

      // @todo Make it without "header" and "print_r" functions.
      // @link https://devdocs.magento.com/guides/v2.4/extension-dev-guide/service-contracts/service-to-web-service.html
        header("Content-Type: application/json; charset=utf-8");
        print_r(json_encode($items), false);
        exit();
    }
}
