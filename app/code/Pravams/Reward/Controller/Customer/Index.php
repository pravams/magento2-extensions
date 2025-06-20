<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pravams\Reward\Controller\Customer;
 
class Index extends \Magento\Framework\App\Action\Action 
{
    /*
    * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @var \Magento\Framework\App\Response\Http $response
    */
    protected $response;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface $redirect
    */
    protected $redirect;

    /**
    * @param \Magento\Framework\App\Action\Context $context
    * @param  \Magento\Customer\Model\Session $customerSession
    * @param array $data
    */
    public function __construct(
            \Magento\Framework\App\Response\Http $response,
            \Magento\Framework\App\Response\RedirectInterface $redirect,
            \Magento\Framework\App\Action\Context $context,
            \Magento\Customer\Model\Session $customerSession
    ){
        $this->customerSession = $customerSession;
        $this->redirect = $redirect;
        $this->response = $response;
        parent::__construct($context);
     }
    /**
     * @return boolean
     */
     
    public function isCustomerLoggedIn(){
        return $this->customerSession->isLoggedIn();
    }
    
    public function execute() 
    {
        if($this->isCustomerLoggedIn()){
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        }else{
              $this->redirect->redirect($this->response, 'customer/account');
        }
        
    }
}