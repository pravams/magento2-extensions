<?php 
namespace Pravams\Ticket\Model;

class Reply extends \Magento\Framework\Model\AbstractModel{

    const TYPE_ADMIN = "admin";
    const TYPE_CUSTOMER = "cutomer";

    protected function _construct(){
        parent::_construct();
        $this->_init('Pravams\Ticket\Model\ResourceModel\Reply');
    }
}