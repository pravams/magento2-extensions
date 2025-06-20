<?php

namespace Pravams\Reward\Model\ResourceModel;

class CustomerPoints extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct(){
        $this->_init('ps_customer_points', 'entity_id');
    }
}
