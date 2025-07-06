<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Model\ResourceModel\ChatMessage;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Pravams\Chat\Model\ChatMessage as Model;
use Pravams\Chat\Model\ResourceModel\ChatMessage as ResourceModel;


class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
    
}
