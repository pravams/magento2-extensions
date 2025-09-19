<?php 
/**
 * Pravams Ticket Module
 * 
 * @category Pravams
 * @package Pravams_Ticket
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Ticket\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;

class View extends \Magento\Backend\Block\Template{

    /**
     * @var \Pravams\Ticket\Model\TicketFactory $ticket
    */
    protected $ticket;

    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Ticket $resTicket
    */
    protected $resTicket;

    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
    */
    protected $replyColl;

    /**
     * @param \Pravams\Ticket\Model\TicketFactory $ticket
     * @param \Pravams\Ticket\Model\ResourceModel\Ticket $resTicket
     * @param \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
    */
    public function __construct(
        Context $context,
        \Pravams\Ticket\Model\TicketFactory $ticket,
        \Pravams\Ticket\Model\ResourceModel\Ticket $resTicket,
        \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl,
        array $data = []
    ){
        $this->ticket = $ticket;
        $this->resTicket = $resTicket;
        $this->replyColl = $replyColl;
        parent::__construct($context, $data);
    }
    
    /**
     * Prepare Layout
     * 
     * @return void
    */
    protected function _prepareLayout(){
        $id = $this->getRequest()->getParam('ticket_id');
        $this->pageConfig->getTitle()->set(__('Ticket # %1', $id));
        $pageTitle = __('# %1', $id);
        $this->getLayout()->getBlock('page.title')->setPageTitle($pageTitle);
    }    

    public function getTicket(){
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = $this->ticket->create();
        $this->resTicket->load($ticket, $id, 'ticket_id');
        return $ticket;
    }

    public function getReplies(){
        $id = $this->getRequest()->getParam('ticket_id');
        $replyColl = $this->replyColl;
        $replies = $replyColl->addFieldToFilter('ticket_id', $id);
        return $replies;
    }
}


