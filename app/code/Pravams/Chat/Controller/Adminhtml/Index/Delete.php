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

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_chatlistData;
    
    protected $chatlistCollection;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Pravams\Chat\Model\ChatFactory $chatlistData,
        \Pravams\Chat\Model\ResourceModel\Chat\Collection $chatlistCollection,
        array $data = []
    )
    {  
        $this->_chatlistData = $chatlistData;
        $this->_pageFactory = $pageFactory;
        $this->chatlistCollection= $chatlistCollection;
        parent::__construct($context);
    }
        
    public function execute()
    {
        $deleteid=$this->getRequest()->getParam("deleteid");
        
        if ( $deleteid) {
            $chatlistCollection=$this->chatlistCollection;
            $chatlistCollection->addFieldToFilter('chat_id',$deleteid);
            $chatlistData=$chatlistCollection->getFirstItem();            
        }
            
        $chatlistData->delete();
        $this->messageManager->addSuccess( __('The chat has been deleted.') );
        //$this->_redirect('*/*/');
        $this->_redirect('pravams_chat/index/index/');
        return;
    }
}
?>