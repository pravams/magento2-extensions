<?php
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/

namespace Pravams\Reservation\Plugin\Block\Sales\Order\Email\Items\Order;

class DefaultOrder{
    /**
     * @var \Magento\Catalog\Model\Product $product
     */
    protected $product;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $store
    */
    protected $store;

    public function __construct(
        \Magento\Catalog\Model\Product $product,
        \Magento\Store\Model\StoreManagerInterface $store
    )
    {
        $this->product = $product;
        $this->store = $store;
    }

    /**
     * @return string
     */
    public function afterGetTemplate(){
        return "Pravams_Reservation::email/items/order/default.phtml";
    }
}

