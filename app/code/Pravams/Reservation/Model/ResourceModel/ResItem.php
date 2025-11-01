<?php
namespace Pravams\Reservation\Model\ResourceModel;

class ResItem extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct(){
        $this->_init('quote_item_option', 'option_id');
    }
}