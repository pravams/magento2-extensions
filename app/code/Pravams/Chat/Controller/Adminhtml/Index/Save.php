<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Controller\Adminhtml\Index;

use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $_pageFactory;
    
    protected $_chatlistData;
    
    protected $_chatlistCollection;
    
    protected $_messagelistData;
    
    protected $_messagelistCollection;

    /**
     * @var \Magento\Customer\Model\Session $_session
     */
    protected $_session;

    /**
     * @var \Magento\Backend\Model\Auth\Session $_authsession
     */
    protected $_authsession;
    
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Pravams\Chat\Model\ChatFactory $chatlistData,
        \Pravams\Chat\Model\ResourceModel\Chat\Collection $chatlistCollection,
        \Pravams\Chat\Model\ChatMessageFactory $messagelistData,
        \Pravams\Chat\Model\ResourceModel\ChatMessage\CollectionFactory $messagelistCollection,
        \Magento\Customer\Model\Session $session,
        \Magento\Backend\Model\Auth\Session $authsession,
        array $data = []
    )  
    {  
        $this->_pageFactory = $pageFactory;
        $this->_chatlistData = $chatlistData;
        $this->_chatlistCollection= $chatlistCollection;
        $this->_messagelistData = $messagelistData;
        $this->_messagelistCollection= $messagelistCollection;
        $this->_session=$session;
        $this->_authsession=$authsession;
        parent::__construct($context);
    }
    public function execute()
    {
        $extensionUser = $this->_authsession->getUser();
        $session=$this->_session;
        
        $chatlistCollection=$this->_chatlistCollection;
        
        $adminId=$extensionUser->getId();
        $adminName=$extensionUser->getUsername();

        $data = $this->getRequest()->getPostValue();
        $chatId=$data["chat_id"];
        $customerId=$data["customer_id"];
        $customerName=$data["customer_name"];

        //check for long message
        if(strlen($data['message']) > 1000){
            $this->messageManager->addNotice( __('Sorry, your message cannot be sent as it is too long!') );
            $this->_redirect('pravams_chat/index/view/', array('viewid' => $chatId));
            return;
        }

        // check if the message is not a SPAM
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $chatMessageRead = $objectManager->get('\Pravams\Chat\Model\ResourceModel\ChatMessage\CollectionFactory')->create();
        $chatMessageRead->addFieldToFilter('admin_id',$adminId);
        $chatMessageRead->addFieldToFilter('customer_viewed',0);        
        if(count($chatMessageRead)>3){
            $this->messageManager->addNotice( __('Sorry, your message cannot be sent, as your previous 4 messages are still Unread!') );
            $this->_redirect('pravams_chat/index/view/', array('viewid' => $chatId));
            return;
        }
        
        $chatlistCollection->addFieldToFilter('customer_id',$customerId);
        $chatlistColl = $chatlistCollection->getFirstItem();
        $chatlistColl->setLastMessage(date("Y-m-d h:i:s"));
        $chatlistColl->save();
        
        
        /** chat message table save */
        $messagelistData=$this->_messagelistData->create();
        $messagelistData->setChatId($chatId);
        $messagelistData->setCustomerId($customerId);
        $messagelistData->setCustomerName($customerName);
        $messagelistData->setAdminId($adminId);
        $messagelistData->setAdminName($adminName);
        $messagelistData->setCustomerViewed(0);
        $messagelistData->setAdminViewed(0);
        $messagelistData->setMessage($data["message"]);
        $messagelistData->setMessageType("admin");

        $messagelistData->save();
        
        
        $this->messageManager->addSuccess( __('Chat mesage sent') );

        //$this->_redirect('*/*/');
        $this->_redirect('pravams_chat/index/view/', array('viewid' => $chatId));
        return;
        
    }
}
?>
