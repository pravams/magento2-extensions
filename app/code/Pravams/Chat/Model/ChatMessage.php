<?php 
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Model;
use Pravams\Chat\Model\ResourceModel\ChatMessage as ChatMessageResourceModel;
use Magento\Framework\Model\AbstractModel;

class ChatMessage extends AbstractModel
{
     protected function _construct()
     {
          $this->_init(ChatMessageResourceModel::class);
     }
   
}
