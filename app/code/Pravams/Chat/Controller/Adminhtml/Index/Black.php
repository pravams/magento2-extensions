<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Chat\Controller\Adminhtml\Index;

class Black extends \Magento\Framework\App\Action\Action
{
       protected $resultPageFactory = false;

       protected $chatData;

       protected $chatBlock;

       protected $chatBlockModel;

       public function __construct(
              \Magento\Backend\App\Action\Context $context,
              \Pravams\Chat\Model\ResourceModel\Chat\Collection $chatData
       ){
              $this->chatData = $chatData;
              parent::__construct($context);
       }

       public function execute(){

              $chatId = $this->getRequest()->getParam('blockid');
              $status = $this->getRequest()->getParam('status');
              
              $chatData = $this->chatData;
              $chatData->addFieldToFilter('chat_id', $chatId);
              $chatObj = $chatData->getFirstItem();              
              
              $chatObj->setBlockStatus($status);
              $chatObj->save();
                     
              if($status==1){
                     $this->messageManager->addSuccess( __('The Customer chat feature has been disabled temporarily') );
              }else{
                     $this->messageManager->addSuccess( __('The Customer chat feature has been enabled now') );
              }                     

              $this->_redirect('pravams_chat/index/view/', array('viewid' => $chatId));
              return;
       }
}
