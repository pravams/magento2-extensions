<?php 
namespace Pravams\Reward\Plugin\Model\Sales\Service;

class InvoiceServicePlugin{

    public function afterPrepareInvoice(
        $subject, $output
    ){
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