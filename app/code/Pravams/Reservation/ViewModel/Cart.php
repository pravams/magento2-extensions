<?php

namespace Pravams\Reservation\ViewModel;

class Cart implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * @var \Magento\Checkout\Model\cart
     */
    protected $cart;

    /**
     * @param \Magento\Checkout\Model\Cart $cart
     */
    public function __construct(
            \Magento\Checkout\Model\Cart $cart
    ) {
        $this->cart = $cart;
    }

    public function getCart(){
        $cart = $this->cart;
        return $cart;
    }
}

