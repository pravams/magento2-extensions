<?php 
namespace Pravams\Ticket\Model\ResourceModel\Ticket;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected function _construct(){
        $this->_init('Pravams\Ticket\Model\Ticket', 'Pravams\Ticket\Model\ResourceModel\Ticket');
    }    
}