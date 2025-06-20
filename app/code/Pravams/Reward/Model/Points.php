<?php
namespace Pravams\Reward\Model;

class Points{
    /**
     * @var \Pravams\Reward\Model\PointsTransactionFactory $pointsTransaction
     */
    protected $pointsTransaction;

    /**
     * @var \Pravams\Reward\Model\ResourceModel\PointsTransaction $pointsTransactionRes
     */
    protected $pointsTransactionRes;

    /**
     * @var \Pravams\Reward\Model\CustomerPointsFactory $customerPoints
     */
    protected $customerPoints;

    /**
     * @var \Pravams\Reward\Model\ResourceModel\CustomerPoints $customerPointsRes
     */
    protected $customerPointsRes;

    /**
     * @param \Pravams\Reward\Model\PointsTransactionFactory $pointsTransaction
     * @param \Pravams\Reward\Model\ResourceModel\PointsTransaction $pointsTransactionRes
     * @param \Pravams\Reward\Model\CustomerPointsFactory $customerPoints
     * @param \Pravams\Reward\Model\ResourceModel\CustomerPoints $customerPointsRes
     */
    public function __construct(
        \Pravams\Reward\Model\PointsTransactionFactory $pointsTransaction,
        \Pravams\Reward\Model\ResourceModel\PointsTransaction $pointsTransactionRes,
        \Pravams\Reward\Model\CustomerPointsFactory $customerPoints,
        \Pravams\Reward\Model\ResourceModel\CustomerPoints $customerPointsRes
    ){
        $this->pointsTransaction = $pointsTransaction;
        $this->pointsTransactionRes = $pointsTransactionRes;
        $this->customerPoints = $customerPoints;
        $this->customerPointsRes = $customerPointsRes;
    }

    public function add($customerId, $points, $action, $event, $eventDetails){
        $pointsTransaction = $this->pointsTransaction->create();
        $pointsTransaction->setCustomerId($customerId);
        $pointsTransaction->setPoints($points);
        $pointsTransaction->setAction($action);
        $pointsTransaction->setEvent($event);
        $pointsTransaction->setEventDetails($eventDetails);        
        $this->pointsTransactionRes->save($pointsTransaction);

        /** add the points to the customer */
        $customerPoints = $this->customerPoints->create();
        $this->customerPointsRes->load($customerPoints, $customerId, 'customer_id');
        if($customerPoints->getId()){
            $totalPoints = $customerPoints->getTotalPoints();
        }else{
            $totalPoints = 0;
        }
        
        $totalPoints = $totalPoints + $points;
        $customerPoints->setCustomerId($customerId);
        $customerPoints->setTotalPoints($totalPoints);
        $this->customerPointsRes->save($customerPoints);        
    }

    public function subtract($customerId, $points, $action, $event, $eventDetails, $orderId=0, $redeemValue=0){
        $pointsTransaction = $this->pointsTransaction->create();
        $pointsTransaction->setCustomerId($customerId);
        $pointsTransaction->setPoints($points);
        $pointsTransaction->setAction($action);
        $pointsTransaction->setEvent($event);
        $pointsTransaction->setEventDetails($eventDetails);
        $pointsTransaction->setOrderId($orderId);
        $pointsTransaction->setRedeemValue($redeemValue);
        $this->pointsTransactionRes->save($pointsTransaction);

        /** add the points to the customer */
        $customerPoints = $this->customerPoints->create();
        $this->customerPointsRes->load($customerPoints, $customerId, 'customer_id');
        if($customerPoints->getId()){
            $totalPoints = $customerPoints->getTotalPoints();
        }else{
            $totalPoints = 0;
        }
        $totalPoints = $totalPoints - $points;
        $customerPoints->setCustomerId($customerId);
        $customerPoints->setTotalPoints($totalPoints);
        $this->customerPointsRes->save($customerPoints);
    }
}
