<?php

namespace Pravams\Reservation\Plugin\Model\Checkout\Provider;

use Magento\Framework\Exception\LocalizedException;

    class Dateplugin
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

        public function afterGetConfig($subject, $output)
        {
            $cart = $this->cart;
            $cartItems = $cart->getQuote()->getItems();
            foreach ($cartItems as $_cartItem){
                if ($_cartItem->getProduct()->getTypeId() == \Pravams\Reservation\Model\Product\Type\Reservation:: TYPE_ID){
                    $option = $_cartItem->getProduct()->getTypeInstance(true)->getOrderOptions($_cartItem->getProduct());
                    $name = $option['info_buyRequest']['reservation_name'];
                    $date = $option['info_buyRequest']['reservation_date'];
                    $_cartItem->setReservationName($name);
                    $_cartItem->setReservationDate($date);
                    $_cartItem->save();
                    $output['reservation_name'] = $name;
                    $output['reservation_date'] = $date;                    
                }
           }
           return $output;
        }
}