<?php
namespace Pravams\Reward\Model\ResourceModel;

class PointsTransaction extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct(){
        $this->_init('ps_customer_points_transaction','entity_id');
    }
}
