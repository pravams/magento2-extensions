<?php
namespace Pravams\Reward\Model;

class CustomerPoints extends \Magento\Framework\Model\AbstractModel{

    protected function _construct(){
        parent::_construct();
        $this->_init('Pravams\Reward\Model\ResourceModel\CustomerPoints');
        
    }
}
