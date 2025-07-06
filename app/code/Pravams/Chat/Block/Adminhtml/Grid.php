<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
namespace Pravams\Chat\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;

class Grid extends \Magento\Backend\Block\Template
{
    public function __construct(Context $context, 
    \Pravams\Chat\Model\ResourceModel\Chat\Collection $chatlistData,
    \Pravams\Chat\Model\ResourceModel\ChatMessage\CollectionFactory $chatMessageCollection,
     array $data = [])
    {
        $this->_chatMessageCollection = $chatMessageCollection;
        $this->_chatlistData = $chatlistData;
        parent::__construct($context, $data);
    }

    public function getChatMessageData(){
        $chatMessageCollection =$this->_chatMessageCollection->create();
        return $chatMessageCollection;
    }

    public function getChatData(){
        $chatlistColletion =$this->_chatlistData;
        $chatlistColletion->setOrder('last_message','DESC');
        return $chatlistColletion;         
    }
}
