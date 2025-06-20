<?php
namespace Pravams\Reward\Model\Sales\Order\Pdf;

class Reward extends \Magento\Sales\Model\Order\Pdf\Total\DefaultTotal{
    /**
     * Get array of arrays with totals information for display in pdf
     * array(
     *  $index => array(
     *      'amount' => $amount,
     *      'label'  => $label,
     *      'font_size' => $font_size
     * )
     * )
     * @return array
     */
    public function getTotalsForDisplay(){
        $order = $this->getOrder();
        $orderId = $order->getIncrementId();

        $obj = \Magento\Framework\App\ObjectManager::getInstance();
        $pointsTransaction = $obj->get('Pravams\Reward\Model\ResourceModel\PointsTransaction\Collection');
        $pointsTransactionData = $pointsTransaction->addFieldToFilter('order_id', $orderId);
        $discountValue = 0;
        if(count($pointsTransactionData)>0){
            $discountValue = $pointsTransactionData->getFirstItem()->getRedeemValue();
            $amount = $this->getOrder()->formatPriceTxt($discountValue);
            $fontSize = 8;
            $totals = [
                    [
                        'amount' => $this->getAmountPrefix() . $amount,
                        'label' => __('Reward Discount') . ':',
                        'font_size' => $fontSize,
                    ],
                ];
            return $totals;
        }else{
            return [];
        }
    }
}