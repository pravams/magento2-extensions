<?php
namespace Pravams\Ticket\Model\ResourceModel;

class Ticket extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct(){
        $this->_init('ps_ticket', 'ticket_id');
    }
}