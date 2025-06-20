<?php
namespace Pravams\Reward\Observer;

use Magento\Framework\Event\ObserverInterface;

class PlaceOrderAfter implements ObserverInterface{

    /**
     * @var \Pravams\Reward\Model\Points $points
    */
    protected $points;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    protected $scopeConfig;

    /**
     * @var \Magento\Customer\Model\SessionFactory $customerSession
    */
    protected $customerSession;

    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
    */
    protected $checkoutSession;

    /**
     * @param \Pravams\Reward\Model\Points $points
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
    */
    public function __construct(
        \Pravams\Reward\Model\Points $points,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession
    ){
        $this->points = $points;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $customerSession = $this->customerSession->create();
        $customerId = $customerSession->getCustomerId();
        if($customerId){
            if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_purchase_status')){
                return;
            }
            $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_purchase_points');
            $eventDetails = __('Customer earns %1 points after Placing an Order', $points);
            $this->points->add($customerId, $points,
                \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
                \Pravams\Reward\Model\PointsTransaction::Purchase,
                $eventDetails
            );

            //check if the reward points have been applied for redeem
            $checkoutSession = $this->checkoutSession;
            if($checkoutSession->getPsPointsDiscount() > 0){
                $redeemValue = $checkoutSession->getPsPointsDiscount();
                $pointsToUnit = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_point_to_currency');
                $redeemPoints = $redeemValue * $pointsToUnit;
                $eventDetails = __('Customer redeems his %1 points against an order', $redeemPoints);
                $orderId = $observer->getOrder()->getIncrementId();
                $this->points->subtract($customerId, $redeemPoints,
                    \Pravams\Reward\Model\PointsTransaction::ACTION_REDEEM,
                    \Pravams\Reward\Model\PointsTransaction::PlaceOrder,
                    $eventDetails,
                    $orderId,
                    $redeemValue
                );
                $checkoutSession->unsPsPointsDiscount();
            }
        }
    }
}
