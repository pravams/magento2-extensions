<?php
namespace Pravams\Reward\Model\ResourceModel\PointsTransaction;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct(){
        $this->_init('Pravams\Reward\Model\PointsTransaction','Pravams\Reward\Model\ResourceModel\PointsTransaction');
    }
}
