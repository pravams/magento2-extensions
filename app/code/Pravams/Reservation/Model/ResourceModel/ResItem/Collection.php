<?php 
namespace Pravams\Reservation\Model\ResourceModel\ResItem;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct(){
        $this->_init('Pravams\Reservation\Model\ResItem', 'Pravams\Reservation\Model\ResourceModel\ResItem');
    }    
}