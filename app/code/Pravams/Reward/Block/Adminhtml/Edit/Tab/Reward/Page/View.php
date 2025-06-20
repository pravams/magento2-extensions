<?php
namespace Pravams\Reward\Block\Adminhtml\Edit\Tab\Reward\Page;

class View extends \Magento\Framework\View\Element\Template
{
    protected $customerPointsColletion;
    
    protected $registry;

    /**
     * 
     * @param \Magento\Framework\Registry $registry
     * @param \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
     * @param \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection,
        \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection,
        \Magento\Framework\View\Element\Template\Context $context,           
        array $data = []
    ){
        $this->registry = $registry;
        $this->customerPointsCollection = $customerPointsCollection;
        $this->pointsTransactionCollection = $pointsTransactionCollection;
        parent::__construct($context, $data);
    }
        
    public function getCustomerPointsCollection()
    {
        $customerPointsCollection = $this->customerPointsCollection;
        return $customerPointsCollection;
    }

    public function getPointsTransactionCollection()
    {
        $pointsTransactionCollection = $this->pointsTransactionCollection;
        return $pointsTransactionCollection;
    }
    
    public function getCustomerId()
    {
        $customerId = $this->getRequest()->getParam('id');
        return $customerId;
    }
 }
