<?php
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Reservation\Model\Checkout;

class Cart extends \Magento\Checkout\Model\Cart
{
    /*
     * check if 
     * */
    public function addProduct($productInfo, $requestInfo = null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $routeName = $objectManager->get('\Magento\Framework\App\Request\Http')->getRouteName();
        $controllerName = $objectManager->get('\Magento\Framework\App\Request\Http')->getControllerName();
        $actionName = $objectManager->get('\Magento\Framework\App\Request\Http')->getActionName();
        if($productInfo->getTypeId() == \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID){
            if( ($routeName == "checkout") && ($controllerName=="cart") && $actionName=="add"){
                parent::addProduct($productInfo, $requestInfo);
                return;
            }else{
                throw new \Magento\Framework\Exception\LocalizedException(__('Sorry we can not add.'));
                
            }
        }else{
            parent::addProduct($productInfo, $requestInfo);
            return;
        }
    }
}

