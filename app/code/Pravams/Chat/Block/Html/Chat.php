<?php
namespace Pravams\Chat\Block\Html;

use Magento\Framework\View\Element\Template\Context;

class Chat extends \Magento\Framework\View\Element\Template{
    /**
     * @var \Magento\Customer\Model\Session $_session
     */
    protected $_session;
    
    /**
     * @var \Magento\Framework\App\Http\Context $httpContext
     */
    protected $httpContext;

    /**
     * @var \Pravams\Chat\Model\ResourceModel\ChatMessage\Collection $_collection
     */
    protected $_collection;

    /**
     * @var \Pravams\Chat\Model\ResourceModel\Chat\Collection $chat
    */
    protected $chat;
    
    /**
     * @param Context $context
     * @param \Magento\Customer\Model\Session $_session
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Pravams\Chat\Model\ResourceModel\ChatMessage\Collection $_Collection
     * @param array $data
     */
     public function __construct(
        Context $context, 
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Http\Context $httpContext,
        \Pravams\Chat\Model\ResourceModel\ChatMessage\Collection $collection,
        \Pravams\Chat\Model\ResourceModel\Chat\Collection $chat,
        array $data = []
    )
    {
        $this->httpContext = $httpContext;
        $this->_session = $session;
        $this->_collection= $collection;
        $this->chat = $chat;
        parent::__construct($context, $data);
    }


    public function getChatMessageData(){
        $chatMessageCollection =$this->_collection;
        return $chatMessageCollection;
    }

    public function getCustomerInfo(){
        $session=$this->_session;
        $sessionData = $session->getData();
        return $sessionData;
    }
        
    public function getLogin(){
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
    
    public function getChatmessageCollection(){
        $collection= $this->_collection;
        $sessionData = $this->getCustomerInfo();
        $chatlistCollection = null;
        if(array_key_exists('visitor_data', $sessionData)){
            $customerId=$sessionData['visitor_data']['customer_id'];
            $chatlistCollection = $collection->addFieldToFilter('customer_id',$customerId);
        }
        
        return $chatlistCollection;
    }
    
    public function getChatData(){        
        $chat = $this->chat;
        $chatData = null;
        $sessionData = $this->getCustomerInfo();
        if(array_key_exists('visitor_data', $sessionData)){
            $customerId=$sessionData['visitor_data']['customer_id'];
            $chat->addFieldToFilter('customer_id', $customerId);
            $chatData = $chat->getFirstItem();            
        }
        return $chatData;
    }
}

