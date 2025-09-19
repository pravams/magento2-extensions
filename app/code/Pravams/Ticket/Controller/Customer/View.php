<?php 
namespace Pravams\Ticket\Controller\Customer;

class View extends \Magento\Framework\App\Action\Action{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @var \Magento\Framework\App\Response\Http $response
    */
    protected $response;

    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
    */
    protected $ticketColl;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Response\Http $response
     * @param \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
    */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Response\Http $response,
        \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
    ){
        $this->customerSession = $customerSession;
        $this->response = $response;
        $this->ticketColl = $ticketColl;
        parent::__construct($context);
    }

    /**
     * @return boolean
    */
    public function isCustomerLoggedIn(){
        return $this->customerSession->isLoggedIn();
    }

    public function execute(){
        $params = $this->_request->getParams();
        if(array_key_exists('id',$params)){
            $ticketId = $params['id'];
            $ticketColl = $this->ticketColl;
            $ticketColl->addFieldToFilter('ticket_id',$ticketId);
            $ticket = $ticketColl->getFirstItem();
            
            $customerSession = $this->customerSession;
            $customerId = $customerSession->getCustomerId();
            
            if($customerId == $ticket->getCustomerId()){
                $this->_view->loadLayout();
                $this->_view->renderLayout();
            }else{
                $this->_redirect->redirect($this->response, 'customer/account');    
            }
        }else{
            $this->_redirect->redirect($this->response, 'customer/account');
        }        
    }
}