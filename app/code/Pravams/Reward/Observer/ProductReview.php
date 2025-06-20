<?php

namespace Pravams\Reward\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductReview implements ObserverInterface{

    /**
     * @var \Pravams\Reward\Model\Points $points
    */
    protected $points;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Message\ManagerInterface $message
    */
    protected $message;

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
     * @param \Magento\Framework\Message\ManagerInterface $message
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
    */
    public function __construct(
        \Pravams\Reward\Model\Points $points,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Message\ManagerInterface $message,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection $pointsTransactionCollection
    ){
        $this->points = $points;
        $this->scopeConfig = $scopeConfig;
        $this->message = $message;
        $this->customerSession = $customerSession;
        $this->pointsTransactionCollection = $pointsTransactionCollection;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $customerSession = $this->customerSession->create();
        $customerId = $customerSession->getCustomerId();
        $message = $this->message;

        $pointsTransactionCollection = $this->pointsTransactionCollection;
        $pointsTransactionCollection->addFieldToFilter('customer_id', $customerId);
        $pointsTransactionCollection->addFieldToFilter('event',\Pravams\Reward\Model\PointsTransaction::Review);
        if(count($pointsTransactionCollection) == 0){
            $this->createReviewPoints($customerId, $message);
        }else{
            $nowSub = $pointsTransactionCollection->getLastItem()->getCreatedAt();
            $nowSubTime = time() - strtotime($nowSub);
            $diff = $nowSubTime/(60*60);
            $diff = floor($diff);
            // check for the 24 hour limit first
            if($diff > 24){
                $this->createReviewPoints($customerId, $message);
            }
        }
        
    }

    private function createReviewPoints($customerId, $message){
        if($customerId && ($message->getMessages()->getLastAddedMessage()->getText() == "You submitted your review for moderation.") ){
            if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_reviews_status')){
                return;
            }
            $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_reviews_points');
            $eventDetails = __('Customer earns %1 points after Submitting a Product Review', $points);
            $this->points->add($customerId, $points,
                \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
                \Pravams\Reward\Model\PointsTransaction::Review,
                $eventDetails
            );
        }
    }
}
