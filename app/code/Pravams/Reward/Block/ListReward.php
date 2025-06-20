<?php
/**
 * Pravams Reward Module
 *
 * @category    Pravams
 * @package     Pravams_Reward
 * @copyright   Copyright (c) 2022 Pravams. (http://www.pravams.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
 */
namespace Pravams\Reward\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Pravams\Reward\Model\PointsTransaction;
use Magento\Framework\Pricing\Helper\Data as priceHelper;


class ListReward extends Template
{
    /**
     * 
     * @var $customCollection
     */
    protected $customCollection;
    /**
     * 
     * @var $priceHelper
     */
    protected $priceHepler;
    /**
     * 
     * @var $customerSession
     */
    protected $customerSession;
    /**
     * 
     * @var $customerPointsCollection
     */
    protected $customerPointsCollection;
    /**
     * 
     * @param Context $context
     * @param PointsTransaction $customCollection
     * @param priceHelper $priceHepler
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection
     */
    public function __construct(Context $context, PointsTransaction $customCollection,
            priceHelper $priceHepler,\Magento\Customer\Model\Session $customerSession,
           \Pravams\Reward\Model\ResourceModel\CustomerPoints\Collection $customerPointsCollection)
    {
        $this->customCollection = $customCollection;
        $this->priceHepler = $priceHepler;
        $this->customerSession = $customerSession;
        $this->customerPointsCollection = $customerPointsCollection;
        parent::__construct($context);
    }
    
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Reward Pagination'));
        if ($this->getCustomCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'pravams.reward.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                 $this->getCustomCollection()
                );
         $this->setChild('pager', $pager);
         $this->getCustomCollection()->load();
        }
        return $this;
    }
    
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    
    public function getCustomCollection()
    {
        $customerId = $this->customerSession->getCustomerId();

        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->customCollection->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
    
    public function getFormattedPrice($price)
    {
        return $this->priceHepler->currency(number_format($price, 2), true, false);
    }
    
    public function getCustomerSession()
    {
        $customerSession=$this->customerSession;
        return $customerSession;
    }
    
    public function getCustomerPointsCollection()
    {
        $customerPointsCollection=$this->customerPointsCollection;
        return $customerPointsCollection;
    }
    
}
 