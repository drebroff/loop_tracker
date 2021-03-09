<?php
declare(strict_types=1);

namespace Loop\Tracker\Model;

use Loop\Tracker\Api\Data\ItemsInterfaceFactory;
use Loop\Tracker\Api\Data\ItemsSearchResultsInterfaceFactory;
use Loop\Tracker\Api\ItemsRepositoryInterface;
use Loop\Tracker\Model\ResourceModel\Items as ResourceItems;
use Loop\Tracker\Model\ResourceModel\Items\CollectionFactory as ItemsCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class ItemsRepository implements ItemsRepositoryInterface
{

    protected $searchResultsFactory;

    protected $dataItemsFactory;

    private $storeManager;

    protected $dataObjectProcessor;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $dataObjectHelper;

    protected $itemsCollectionFactory;

    protected $itemsFactory;

    protected $extensibleDataObjectConverter;
    protected $resource;


    /**
     * @param ResourceItems $resource
     * @param ItemsFactory $itemsFactory
     * @param ItemsInterfaceFactory $dataItemsFactory
     * @param ItemsCollectionFactory $itemsCollectionFactory
     * @param ItemsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceItems $resource,
        ItemsFactory $itemsFactory,
        ItemsInterfaceFactory $dataItemsFactory,
        ItemsCollectionFactory $itemsCollectionFactory,
        ItemsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->itemsFactory = $itemsFactory;
        $this->itemsCollectionFactory = $itemsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataItemsFactory = $dataItemsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Loop\Tracker\Api\Data\ItemsInterface $items
    ) {
        /* if (empty($items->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $items->setStoreId($storeId);
        } */
        
        $itemsData = $this->extensibleDataObjectConverter->toNestedArray(
            $items,
            [],
            \Loop\Tracker\Api\Data\ItemsInterface::class
        );
        
        $itemsModel = $this->itemsFactory->create()->setData($itemsData);
        
        try {
            $this->resource->save($itemsModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the items: %1',
                $exception->getMessage()
            ));
        }
        return $itemsModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($itemsId)
    {
        $items = $this->itemsFactory->create();
        $this->resource->load($items, $itemsId);
        if (!$items->getId()) {
            throw new NoSuchEntityException(__('Items with id "%1" does not exist.', $itemsId));
        }
        return $items->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->itemsCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Loop\Tracker\Api\Data\ItemsInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Loop\Tracker\Api\Data\ItemsInterface $items
    ) {
        try {
            $itemsModel = $this->itemsFactory->create();
            $this->resource->load($itemsModel, $items->getItemsId());
            $this->resource->delete($itemsModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Items: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($itemsId)
    {
        return $this->delete($this->get($itemsId));
    }
}

