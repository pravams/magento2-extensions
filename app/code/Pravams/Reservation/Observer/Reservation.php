<?php 
namespace Pravams\Reservation\Observer;

use Magento\Framework\Event\ObserverInterface;

class Reservation implements ObserverInterface{

    /**
     * @var \Magento\Checkout\Model\Cart $cart
    */
    protected $cart;

    /**    
     * @param \Magento\Checkout\Model\Cart $cart
    */
    public function __construct(
        \Magento\Checkout\Model\Cart $cart
    ){
        $this->cart = $cart;
    }   
    
    public function execute(\Magento\Framework\Event\Observer $observer){
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();
        
        $cart = $this->cart;
        $cartItems = $cart->getQuote()->getItems();
        foreach($cartItems as $_cartItem){
            if ($_cartItem->getProduct()->getTypeId() ==  \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID ){
                $_cartItem->setOrderId($orderId);
                $_cartItem->save();
            }
        }
    }

}

