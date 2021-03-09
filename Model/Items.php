<?php
declare(strict_types=1);

namespace Loop\Tracker\Model;

use Loop\Tracker\Api\Data\ItemsInterface;
use Loop\Tracker\Api\Data\ItemsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Items extends \Magento\Framework\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $_eventPrefix = 'loop_tracker_items';
    protected $itemsDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ItemsInterfaceFactory $itemsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Loop\Tracker\Model\ResourceModel\Items $resource
     * @param \Loop\Tracker\Model\ResourceModel\Items\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ItemsInterfaceFactory $itemsDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Loop\Tracker\Model\ResourceModel\Items $resource,
        \Loop\Tracker\Model\ResourceModel\Items\Collection $resourceCollection,
        array $data = []
    ) {
        $this->itemsDataFactory = $itemsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve items model with items data
     * @return ItemsInterface
     */
    public function getDataModel()
    {
        $itemsData = $this->getData();
        
        $itemsDataObject = $this->itemsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $itemsDataObject,
            $itemsData,
            ItemsInterface::class
        );
        
        return $itemsDataObject;
    }
}

