<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pravams\Reward\Controller\Customer;
class Redeem extends \Magento\Framework\App\Action\Action 
{

  /**
   * @var \Magento\Framework\App\Response\Http $response
  */
  protected $response;

  /**
   * @var \Magento\Framework\App\Response\RedirectInterface $redirect
  */
  protected $redirect;

  /**
   * @var \Magento\Framework\App\Action\Context $context
  */
  protected $context;

  /**
   * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
  */
  protected $scopeConfig;

  /**
   * @var \Magento\Checkout\Model\Session $checkoutSession
  */
  protected $checkoutSession;

  /**
   * @var \Magento\Customer\Model\Session $customerSession
  */
  protected $customerSession;

  /**
   * @var \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
  */
  protected $customerPointsCollection;

  /**
   * @param \Magento\Framework\App\Response\Http $response
   * @param \Magento\Framework\App\Response\RedirectInterface $redirect
   * @param \Magento\Framework\App\Action\Context $context
   * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
   * @param \Magento\Checkout\Model\Session $checkoutSession
   * @param \Magento\Customer\Model\Session $customerSession
   * @param \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
  */
  public function __construct(
    \Magento\Framework\App\Response\Http $response,
    \Magento\Framework\App\Response\RedirectInterface $redirect,
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Checkout\Model\Session $checkoutSession,
    \Magento\Customer\Model\Session $customerSession,
    \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
  ){
      $this->response=$response;
      $this->redirect=$redirect;
      $this->scopeConfig = $scopeConfig;
      $this->checkoutSession = $checkoutSession;
      $this->customerSession = $customerSession;
      $this->customerPointsCollection = $customerPointsCollection;
      parent::__construct($context);
  }

  public function execute(){
    $params = $this->getRequest()->getParams();
    if(array_key_exists('ps_points', $params)){
      $psPoints = $params['ps_points'];
    }else{
      $psPoints=0;
    }
    
    $isRemove = $params['remove'];
  

    $pointsToUnit = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_point_to_currency');
    if($psPoints > 0){
      $customerSession = $this->customerSession;
      $customerId = $customerSession->getCustomerId();
      $customerPointsColl = $this->customerPointsCollection->addFieldToFilter('customer_id', $customerId);
      $customerPoints = $customerPointsColl->getFirstItem()->getTotalPoints();
      
      if($customerPoints < $psPoints){
        $errorMessage = 'Sorry you do not have '.$psPoints.' points in your account';
        $this->messageManager->addErrorMessage($errorMessage);
      }else{
        $discountAmount = intval($psPoints / $pointsToUnit);                
        $checkoutSession = $this->checkoutSession;
        $checkoutSession->setPsPointsDiscount($discountAmount);
        $this->messageManager->addSuccessMessage('Your points have been used to discount the shopping cart');
      }
    }

    //remove reward points
    if($isRemove == 1){
      $checkoutSession = $this->checkoutSession;
      $checkoutSession->unsPsPointsDiscount();
      $this->messageManager->addSuccessMessage('Your reward points are removed from the shopping cart');
    }

    $this->redirect->redirect($this->response, 'checkout/cart/index');
  }
}