<?php
namespace Pravams\Reward\Model;

class PointsTransaction extends \Magento\Framework\Model\AbstractModel{
    const Registration = "Registration";
    const Newsletter = "Newsletter";
    const Purchase = "Purchase";
    const Review = "Review";
    const Wishlist_Share = "Wishlist Share";
    const Manual = "Manual";

    const PlaceOrder = "PlaceOrder";

    const ACTION_EARN = "earn";
    const ACTION_REDEEM = "redeem";

    protected function _construct(){
        parent::_construct();
        $this->_init('Pravams\Reward\Model\ResourceModel\PointsTransaction');
    }
}
