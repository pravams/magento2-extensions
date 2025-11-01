<?php 
namespace Pravams\Reservation\Model;

class ResItem extends \Magento\Framework\Model\AbstractModel{

    protected function _construct(){
        parent::_construct();
        $this->_init('Pravams\Reservation\Model\ResourceModel\ResItem');
    }
}