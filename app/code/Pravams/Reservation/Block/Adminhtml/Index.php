<?php 
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Reservation\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;

class Index extends \Magento\Backend\Block\Template{
    
    /**
     * @var \Magento\Quote\Model\ResourceModel\Quote\Item\Collection $quoteItemColl
    */
    protected $quoteItemColl;

    /***
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderColl
    */
    protected $salesOrderColl;

    /**
     * @param \Magento\Quote\Model\ResourceModel\Quote\Item\Collection $quoteItemColl
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderColl
    */
    public function __construct(
        Context $context,
        \Magento\Quote\Model\ResourceModel\Quote\Item\Collection $quoteItemColl,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderColl,
        array $data = []
    ){
        $this->quoteItemColl = $quoteItemColl;
        $this->salesOrderColl = $salesOrderColl;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout(){
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Tickets list'));
        if($this->getCustomCollection()){
            $pager = $this->getLayout()->createBlock(
                'Pravams\Core\Block\Html\Pager',
                'pravams.adminreservation.page',                
            )->setAvailableLimit([5=>5, 10=>10,15=>15,20=>20])
            ->setShowPerPage(true)->setCollection(
                $this->getCustomCollection()
            );
            $this->setChild('pager', $pager);
            $this->getCustomCollection()->load();
        }
    }

    public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }

    public function getCustomCollection(){
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->quoteItemColl->setOrder('created_at', 'DESC');;
        $collection = $this->addGridFilter($collection);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }       
    
    public function addGridFilter($collection){
        $request = $this->getRequest();
        $params = $request->getParams();

        $collection->addFieldToFilter('product_type', \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID);

        if(array_key_exists('name', $params)){            
            if(strlen($params['name']) > 0){
                $collection->addFieldToFilter('name', ['like' => '%'.$params['name'].'%']);
            }            
        }        
        if(array_key_exists('reservation_name', $params)){            
            if(strlen($params['reservation_name']) > 0){
                $collection->addFieldToFilter('reservation_name', ['like' => '%'.$params['reservation_name'].'%']);
            }            
        }        
        if(array_key_exists('order_id', $params)){            
            if(strlen($params['order_id']) > 0){
                $collection->addFieldToFilter('order_id', ['like' => '%'.$params['order_id'].'%']);
            }
        }
        
        if(array_key_exists('reservation_date', $params)){
            $createdAt = $params['reservation_date'];
            if(array_key_exists('from', $createdAt)){
                $fromDate = $createdAt['from'];
                if(strlen($fromDate) > 0){
                    $collection->addFieldToFilter('reservation_date', ['gt' => $fromDate]);
                }    
            }
            if(array_key_exists('to', $createdAt)){
                $toDate = $createdAt['to'];
                if(strlen($toDate) > 0){
                    $collection->addFieldToFilter('reservation_date', ['lt' => $toDate]);
                }    
            }
        }
        
        return $collection;
    }

    public function getGridFieldValue($key){
        $params = $this->getRequest()->getParams();
        if(array_key_exists($key, $params)){
            if(strlen($params[$key]) > 0){
                return $params[$key];
            }else{
                return "";
            }
        }else{
            return "";
        }
    }

    public function getSalesOrder($incrementId){
        $salesOrderColl = $this->salesOrderColl->create();;
        $salesOrder = $salesOrderColl->addFieldToFilter('increment_id', $incrementId)->getFirstItem();
        return $salesOrder;
    }
}
