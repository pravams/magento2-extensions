<?php
namespace Pravams\Ticket\Model\ResourceModel;

class Reply extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct(){
        $this->_init('ps_ticket_reply', 'reply_id');
    }
}