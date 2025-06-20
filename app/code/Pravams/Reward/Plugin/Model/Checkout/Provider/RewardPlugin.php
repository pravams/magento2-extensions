<?php 
namespace Pravams\Reward\Plugin\Model\Checkout\Provider;

use Magento\Framework\Exception\LocalizedException;

class RewardPlugin{
    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
    */
    protected $checkoutSession;

    /**
     * @var \Magento\Directory\Model\Currency $currency
    */
    protected $currency;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Directory\Model\Currency $currency
    */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Directory\Model\Currency $currency
    ){
        $this->checkoutSession = $checkoutSession;
        $this->currency = $currency;
    }

    public function afterGetConfig($subject, $output){
        $checkoutSession = $this->checkoutSession;
        $currency = $this->currency;
        $rewardDiscount = $checkoutSession->getPsPointsDiscount();
        if($rewardDiscount > 0){
            $output['ps_reward_points'] = $currency->getCurrencySymbol().$rewardDiscount;
        }
        return $output;
    }
}