<?php
namespace Pravams\Reward\Observer;

use Magento\Framework\Event\ObserverInterface;

class AfterRegistration implements ObserverInterface{

    /**
     * @var \Pravams\Reward\Model\Points $points
    */
    protected $points;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @param \Pravams\Reward\Model\Points $points
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    public function __construct(
        \Pravams\Reward\Model\Points $points,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->points = $points;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $customerId = $observer->getData()['customer']->getId();

        if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_registration_status')){
            return;
        }
        $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_registration_points');
        $eventDetails = __('Customer earns %1 points after a Successful Registration',$points);
        $this->points->add($customerId, $points,
            \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
            \Pravams\Reward\Model\PointsTransaction::Registration,
            $eventDetails
        );
    }
}
