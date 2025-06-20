<?php
namespace Pravams\Reward\Observer;

use Magento\Framework\Event\Observer;

class NewsLetter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    */
    protected $resultRawFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\Collection $customerCollection
    */
    protected $customerCollection;

    /**
     * @var \Magento\Customer\Model\SessionFactory $customerSession
    */
    protected $customerSession;

    /**
     * @var \Pravams\Reward\Model\Points $points
    */
    protected $points;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Customer\Model\ResourceModel\Customer\Collection $customerCollection
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param \Pravams\Reward\Model\Points $points
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    */
    public function __construct(
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Customer\Model\ResourceModel\Customer\Collection $customerCollection,
        \Magento\Customer\Model\SessionFactory $customerSession,
        \Pravams\Reward\Model\Points $points,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->resultRawFactory= $resultRawFactory;
        $this->customerCollection=$customerCollection;
        $this->customerSession = $customerSession;
        $this->points = $points;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer){         
        $subscriber = $observer->getEvent()->getSubscriber();
        $email = $subscriber->getEmail();
        $subscriberStatus = $subscriber->getSubscriberStatus();
        $customerSession=$this->customerSession->create();
        if($customerSession->isLoggedIn()){
               $customerId = $customerSession->getCustomerId();
               $collection= $this->customerCollection;
               $collection->addFieldToFilter('entity_id',$customerId);
               $customer=$collection->getFirstItem();
           if($customerId){
                if($email==$customer->getEmail()){
                    if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_newsletter_status')){
                       return;
                }

                $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_newsletter_points');
                $eventDetails = __('Customer earns %1 points after Sharing the Wishlist', $points);
                $this->points->add($customerId, $points,
                    \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
                    \Pravams\Reward\Model\PointsTransaction::Newsletter,
                    $eventDetails
                );
              }
          }
        }else{
            $collection= $this->customerCollection;
            $collection->addFieldToFilter('email',$email);
            if($collection->count()>0){
                $customer=$customer=$collection->getFirstItem();;
                $customerId= $customer->getId();
                if(!$this->scopeConfig->getValue('reward/reward_points_configuration/reward_newsletter_status')){
                    return;
                }
                $points = $this->scopeConfig->getValue('reward/reward_points_configuration/reward_newsletter_points');
                $eventDetails = __('Customer earns %1 points after Sharing the Wishlist', $points);
                $this->points->add($customerId, $points,
                    \Pravams\Reward\Model\PointsTransaction::ACTION_EARN,
                    \Pravams\Reward\Model\PointsTransaction::Newsletter,
                    $eventDetails
                );
            }
        }
    }
}