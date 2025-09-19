<?php 
namespace Pravams\Ticket\Block;

use Magento\Framework\View\Element\Template\Context;

class Tab extends \Magento\Framework\View\Element\Template{
    /**
     * @var \Pravams\Ticket\Model\Ticket $ticketList
    */
    protected $ticketList;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
    */
    protected $customerSession;

    /**
     * @param \Pravams\Ticket\Model\Ticket $ticketList
     * @param \Magento\Customer\Model\Session $customerSession
    */
    public function __construct(
        Context $context,
        \Pravams\Ticket\Model\Ticket $ticketList,
        \Magento\Customer\Model\Session $customerSession
    ){
        $this->ticketList = $ticketList;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    protected function _prepareLayout(){
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Tickets List'));
        if($this->getCustomCollection()){
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'pravams.tickets.pages'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getCustomCollection()
                );
            $this->setChild('pager', $pager);
            $this->getCustomCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }
    
    public function getCustomCollection(){
        $customerSession = $this->customerSession;
        $customerId = $customerSession->getCustomerId();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->ticketList->getCollection();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }           
}