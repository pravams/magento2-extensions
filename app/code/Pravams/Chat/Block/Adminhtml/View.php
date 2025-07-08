<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;

class View extends \Magento\Backend\Block\Template
{
    /**
     * @var \Pravams\Chat\Model\ResourceModel\ChatMessage\Collection $collection
     */
    protected $collection;

    /**
     * @var \Magento\Backend\Model\Auth\Session $authsession
    */
    protected $_authsession;
    
    public function __construct(Context $context, 
    \Pravams\Chat\Model\ResourceModel\ChatMessage\Collection $collection,
    \Magento\Backend\Model\Auth\Session $authSession,
     array $data = [])
    {
        $this->collection = $collection;
        $this->_authsession = $authSession;
        parent::__construct($context, $data);
    }

    public function getChatCollection(){
        $params = $this->getRequest()->getParams();
        $chatId=$params['viewid'];
        $collection = $this->collection;
        $chatlistCollection = $collection->addFieldToFilter('chat_id',$chatId);
        //$chatlistCollection = $collection->addFieldToFilter('customer_viewed',$customerviewed);
        return $chatlistCollection;    
    }

    public function getAdminUser(){
        $extensionUser = $this->_authsession->getUser();        
        return $extensionUser;
    }

    public function getAdminId(){
        $extensionUser = $this->getAdminUser();
        
        $adminId=$extensionUser->getId();
        return $adminId;
    }

    public function getAdminName(){
        $extensionUser = $this->getAdminUser();
        
        $adminName=$extensionUser->getUsername();
        return $adminName;
    }
    
}

