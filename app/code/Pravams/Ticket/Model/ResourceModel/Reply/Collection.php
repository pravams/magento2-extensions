<?php 
namespace Pravams\Ticket\Model\ResourceModel\Reply;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct(){
        $this->_init('Pravams\Ticket\Model\Reply', 'Pravams\Ticket\Model\ResourceModel\Reply');
    }    
}