<?php
declare(strict_types=1);

namespace Loop\Tracker\Model\ResourceModel;

class Items extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('loop_tracker_items', 'items_id');
    }
}

