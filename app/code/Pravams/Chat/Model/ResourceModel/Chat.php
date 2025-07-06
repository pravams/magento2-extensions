<?php 
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Chat extends AbstractDb
{
     protected function _construct()
     {
          $this->_init('pravams_chat', 'chat_id');
     }
}
