<?php 
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://wwww.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Reservation\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    protected $resultPageFactory = false;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ){
        $this->resultPageFactory = $resultPageFactory;        
        parent::__construct($context);
    }

    public function execute(){
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTItle()->prepend(__('Reservation'));
        return $resultPage;
    }
}