<?php
namespace Pravams\Ticket\Controller\Customer;

class Create extends \Magento\Framework\App\Action\Action{

    /**
     * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @var \Magento\Framework\App\Response\Http $response
    */
    protected $response;

    /**
     * @param \Magento\Framework\App\Response\Http $response
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
    */
    public function __construct(
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ){
        $this->customerSession = $customerSession;
        $this->response = $response;
        parent::__construct($context);
    }

    /**
     * @return boolean
    */
    public function isCustomerLoggedIn(){
        return $this->customerSession->isLoggedIn();
    }

    public function execute(){
        if($this->isCustomerLoggedIn()){
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        }else{
            $this->_redirect->redirect($this->response, 'customer/account');
        }
    }
}