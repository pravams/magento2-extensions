<?php 
/**
 * Pravams Ticket Module
 * 
 * @category Pravams
 * @package Pravams_Ticket
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Ticket\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;

class Index extends \Magento\Backend\Block\Template{
    
    /**
     * @var \Pravams\Ticket\Model\Ticket $ticketList
    */
    protected $ticketList;

    /**
     * @param \Pravams\Ticket\Model\Ticket $ticketList
    */
    public function __construct(
        Context $context,
        \Pravams\Ticket\Model\Ticket $ticketList,
        array $data = []
    ){
        $this->ticketList = $ticketList;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout(){
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Tickets list'));
        if($this->getCustomCollection()){
            $pager = $this->getLayout()->createBlock(
                'Pravams\Core\Block\Html\Pager',
                'pravams.admintickets.page',                
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
        $collection = $this->ticketList->getCollection();
        $collection = $this->addGridFilter($collection);
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }       
    
    public function addGridFilter($collection){
        $request = $this->getRequest();
        $params = $request->getParams();
        if(array_key_exists('customer_name', $params)){            
            if(strlen($params['customer_name']) > 0){
                $collection->addFieldToFilter('customer_name', ['like' => '%'.$params['customer_name'].'%']);
            }            
        }        
        if(array_key_exists('ticket_id', $params)){            
            if(strlen($params['ticket_id']) > 0){
                $collection->addFieldToFilter('ticket_id', ['like' => '%'.$params['ticket_id'].'%']);
            }
        }
        if(array_key_exists('customer_email', $params)){            
            if(strlen($params['customer_email']) > 0){
                $collection->addFieldToFilter('customer_email', ['like' => '%'.$params['customer_email'].'%']);
            }
        }
        if(array_key_exists('status', $params)){     
            if(strlen($params['status']) > 0){
                $collection->addFieldToFilter('status', ['like' => '%'.$params['status'].'%']);
            }       
        }
        if(array_key_exists('subject', $params)){     
            if(strlen($params['subject']) > 0){
                $collection->addFieldToFilter('subject', ['like' => '%'.$params['subject'].'%']);
            }       
        }
        if(array_key_exists('assigned_to', $params)){            
            if(strlen($params['assigned_to']) > 0){
                $collection->addFieldToFilter('assigned_admin_name', ['like' => '%'.$params['assigned_to'].'%']);
            }
        }
        if(array_key_exists('priority', $params)){
            if(strlen($params['priority']) > 0){
                $collection->addFieldToFilter('priority_level', ['like' => '%'.$params['priority'].'%']);
            }              
        }

        if(array_key_exists('created_at', $params)){
            $createdAt = $params['created_at'];
            if(array_key_exists('from', $createdAt)){
                $fromDate = $createdAt['from'];
                if(strlen($fromDate) > 0){
                    $collection->addFieldToFilter('created_at', ['gt' => $fromDate]);
                }    
            }
            if(array_key_exists('to', $createdAt)){
                $toDate = $createdAt['to'];
                if(strlen($toDate) > 0){
                    $collection->addFieldToFilter('created_at', ['lt' => $toDate]);
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
}
