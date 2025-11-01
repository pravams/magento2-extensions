<?php
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/

namespace Pravams\Reservation\Plugin\Model\Checkout\Cart;

use Magento\Framework\Exception\LocalizedException;

class Plugin
    {
        /**
         * @var \Magento\Checkout\Model\Cart
         */
        protected $cart;

        /**
         * @param \Magento\Checkout\Model\Cart $cart
         * 
         */
        public function __construct(
        \Magento\Checkout\Model\Cart $cart
        ){
            $this->cart = $cart;   
        }

        public function beforeAddProduct($subject, $productInfo, $requestInfo = null)
        {            
            try{
                $cart = $this->cart;
                $cartItems = $cart->getQuote()->getItems();
                if ($productInfo->getTypeId() == \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID){
                    if($cartItems){
                        foreach ($cartItems as $_cartItem){
                            if ($_cartItem->getProductType() == \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID){
                                throw new LocalizedException(__('Sorry you cannot add another reservation product')); 
                            }
                        }  
                    }
                }
            } catch (Exception $ex) {
                throw new LocalizedException(__($ex->getMessage()));
            }

            return [$productInfo, $requestInfo];
        }
    }
