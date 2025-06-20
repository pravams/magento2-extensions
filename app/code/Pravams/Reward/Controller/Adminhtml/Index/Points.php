<?php 
namespace Pravams\Reward\Controller\Adminhtml\Index;

class Points extends \Magento\Customer\Controller\Adminhtml\Index
{
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}