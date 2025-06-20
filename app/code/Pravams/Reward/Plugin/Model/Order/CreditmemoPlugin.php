<?php 
namespace Pravams\Reward\Plugin\Model\Order;

class CreditmemoPlugin{

    public function afterCreateByOrder($subject, $output){
        $orderId = $output->getOrderId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderColl = $objectManager->get('Magento\Sales\Model\ResourceModel\Order\Collection');
        $orderData = $orderColl->addFieldToFilter('entity_id', $orderId);
        $order = $orderData->getFirstItem();
        
        $output->setBaseGrandTotal($order->getBaseGrandTotal());
        $output->setGrandTotal($order->getGrandTotal());

        return $output;
    }

    public function afterCreateByInvoice($subject, $output){
        $orderId = $output->getOrderId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderColl = $objectManager->get('Magento\Sales\Model\ResourceModel\Order\Collection');
        $orderData = $orderColl->addFieldToFilter('entity_id', $orderId);
        $order = $orderData->getFirstItem();
        
        $output->setBaseGrandTotal($order->getBaseGrandTotal());
        $output->setGrandTotal($order->getGrandTotal());

        return $output;
    }
}

?>