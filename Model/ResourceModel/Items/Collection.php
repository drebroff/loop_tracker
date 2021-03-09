<?php
declare(strict_types=1);

namespace Loop\Tracker\Model\ResourceModel\Items;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'items_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Loop\Tracker\Model\Items::class,
            \Loop\Tracker\Model\ResourceModel\Items::class
        );
    }
}

