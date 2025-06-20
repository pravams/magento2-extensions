<?php
namespace Pravams\Reward\Controller\Adminhtml\Index;

class Reward extends \Magento\Customer\Controller\Adminhtml\Index
{  
    public function execute()
    { 
      $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
