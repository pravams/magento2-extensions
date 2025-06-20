<?php
namespace Pravams\Reward\Observer;

use Magento\Framework\Event\ObserverInterface;

class WishlistShare implements ObserverInterface{

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
     * @var \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
    */
    protected $pointsTransactionCollection;

    /**
     * @param \Pravams\Reward\Model\Points $points
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
    */
    public function __construct(
        \Pravams\Reward\Model\Points $points,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
    ){
        $this->points = $points;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->pointsTransactionCollection = $pointsTransactionCollection;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $customerSession = $this->customerSession->create();
        $customerId = $customerSession->getCustomerId();
        
        $pointsTransactionCollection = $this->pointsTransactionCollection;
        $pointsTransactionCollection->addFieldToFilter('customer_id', $customerId);
        $pointsTransactionCollection->addFieldToFilter('event', \Pravams\Reward\Model\PointsTransaction::Wishlist_Share);
        if(count($pointsTransactionCollection) ==  0){
            $this->createWishlistPoints($customerId);
        }else{
            $nowSub = $pointsTransactionCollection->getLastItem()->getCreatedAt();
            $nowSubTime = time() - strtotime($nowSub);
            $diff = $nowSubTime/(60*60);
            $diff = floor($diff);
            // check for the 24 hour limit first
            if($diff > 24){
                $this->createWishlistPoints($customerId);
            }
        }
    }

    private function createWishlistPoints($customerId){
        if($customerId){
            if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_wishlist_share_status')){
                return;
            }
            $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_wishlist_share_points');
            $eventDetails = __('Customer earns %1 points after Sharing the Wishlist', $points);
            $this->points->add($customerId, $points,
                \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
                \Pravams\Reward\Model\PointsTransaction::Wishlist_Share,
                $eventDetails
            );
        }
    }
}
