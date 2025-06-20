<?php
namespace Pravams\Reward\Model\ResourceModel\CustomerPoints;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct(){
        $this->_init('Pravams\Reward\Model\CustomerPoints','Pravams\Reward\Model\ResourceModel\CustomerPoints');
    }
}
