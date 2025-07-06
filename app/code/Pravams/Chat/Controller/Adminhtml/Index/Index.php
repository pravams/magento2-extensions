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
class Index extends \Magento\Backend\App\Action
{
       protected $resultPageFactory=false;

       protected $chatlistData;

       public function __construct(
              \Magento\Backend\App\Action\Context $context,
              \Magento\Framework\View\Result\PageFactory $resultPageFactory,
              \Pravams\Chat\Model\ResourceModel\Chat\Collection $chatlistData
       )
       {         
              parent::__construct($context);
              $this->resultPageFactory=$resultPageFactory;
              $this->chatlistData = $chatlistData;
       }

       public function execute()         
       {
              $resultPage=$this->resultPageFactory->create();
              $resultPage->getConfig()->getTitle()->prepend((__('Chat')));

              // check the latest message and redirect to that chat page
              $chatlistColl = $this->chatlistData;
              
              if(count($chatlistColl) > 0){
                     $chatlistColl->setOrder('last_message','DESC');
                     $chatlistItem = $chatlistColl->getFirstItem();
                     $chatlistItemId = $chatlistItem->getId();

                     $this->_redirect('pravams_chat/index/view/', array('viewid' => $chatlistItemId));
              }else{
                     return $resultPage;
              }
              
       }
}