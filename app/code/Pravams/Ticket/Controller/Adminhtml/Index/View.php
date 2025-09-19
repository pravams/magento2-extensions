<?php 
/**
 * Pravams Ticket Module
 * 
 * @category Pravams
 * @package Pravams_Ticket
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Ticket\Controller\Adminhtml\Index;

class View extends \Magento\Backend\App\Action{

    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ){
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }    

    public function execute(){
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('View Ticket'));

        return $resultPage;
    }
}