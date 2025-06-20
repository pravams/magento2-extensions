<?php

namespace Pravams\Reward\Block;
use Magento\Framework\View\Element\Template\Context;

class CartReward extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Context $context
    */
    protected $context;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @var \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
    */
    protected $customerPointsCollection;

    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
    */
    protected $checkoutSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
    */
    protected $storeManager;

    /**
     * @param Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        parent::__construct($context);
	    $this->customerSession=$customerSession;
        $this->customerPointsCollection=$customerPointsCollection;
        $this->checkoutSession = $checkoutSession;
        $this->storeManager = $storeManager;
    }
         
    public function getCustomerSession(){
        $customerSession=$this->customerSession;
        return $customerSession;
    }
    
    public function getCustomerPointsCollection(){
        $customerPointsCollection=$this->customerPointsCollection;
        return $customerPointsCollection;
    }

    public function getCheckoutSession(){
        $checkoutSession = $this->checkoutSession;
        return $checkoutSession;
    }

    public function getStoreManager(){
        $storeManager = $this->storeManager;
        return $storeManager;
    }
}