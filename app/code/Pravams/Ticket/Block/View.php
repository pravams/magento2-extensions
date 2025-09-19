<?php 
namespace Pravams\Ticket\Block;

use Magento\Framework\View\Element\Template\Context;

class View extends \Magento\Framework\View\Element\Template{
    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
     */    
    protected $ticketColl;

    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
    */
    protected $replyColl;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @var Context $context
    */
    protected $context;

    /**
     * @param \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
     * @param \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
     * @param \Magento\Customer\Model\Session $customerSession
    */
    public function __construct(
        Context $context,
        \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl,
        \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ){
        $this->ticketColl = $ticketColl;
        $this->replyColl = $replyColl;
        $this->customerSession = $customerSession;
        $this->context = $context;
        parent::__construct($context, $data);
    }

    /**
     * Prepare Layout
     * 
     * @return void
    */
    protected function _prepareLayout(){
        $this->pageConfig->getTitle()->set(__('Ticket # %1', $this->getTicketId()));
    }
    

    /**
     * return the ticketId from the request param
    */
    public function getTicketId(){
        $context = $this->context;
        $request = $context->getRequest();
        $ticketId = $request->getParam('id');
        return $ticketId;
    }


    public function getTicketData(){
        $ticketId = $this->getTicketId();
        $ticketColl = $this->ticketColl;
        $ticketColl->addFieldToFilter('ticket_id',$ticketId);
        $ticket = $ticketColl->getFirstItem();
        return $ticket;
    }

    public function getReplies(){
        $ticketId = $this->getTicketId();
        $replyColl = $this->replyColl;
        $replyColl->addFieldToFilter('ticket_id', $ticketId);
        return $replyColl;
    }

    public function getCustomerId(){
        $customerId = $this->customerSession->getCustomerId();
        return $customerId;
    }
}
