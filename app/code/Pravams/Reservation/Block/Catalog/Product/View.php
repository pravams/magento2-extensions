<?php
/*
 * pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2018 Pravams. (http://pravams.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Pravams\Reservation\Block\Catalog\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;

class View extends \Magento\Catalog\Block\Product\View {
       
    
    public function setTemplate($template)
    {
        $type = $this->getProduct()->getTypeId();
        if($type == \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID &&
        $template == "Magento_Catalog::product/view/form.phtml"){
            $template = "Pravams_Reservation::catalog/product/view/reservation.phtml";
        }
        $this->_template = $template;
        return $this;
    }
    
}