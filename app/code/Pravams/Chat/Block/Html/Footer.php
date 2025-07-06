<?php
/**
 * Pravams Chat Module
 * 
 * @category Pravams
 * @package Pravams_Chat
 * @copyright Copyright (c) 2023 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Chat\Block\Html;

use Magento\Framework\View\Element\Template\Context;

class Footer extends \Magento\Framework\View\Element\Template
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context){
        parent::__construct($context);
    }
}
