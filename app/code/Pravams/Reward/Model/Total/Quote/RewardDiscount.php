<?php
namespace Pravams\Reward\Model\Total\Quote;

class RewardDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
    */
    protected $checkoutSession;
 
    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Checkout\Model\Session $checkoutSession
    ){
        $this->_priceCurrency = $priceCurrency;
        $this->checkoutSession = $checkoutSession;
    }
 
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);

        $checkoutSession = $this->checkoutSession;
        $baseDiscount = $checkoutSession->getPsPointsDiscount();

        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('psrewarddiscount', -$discount);
        $total->addBaseTotalAmount('psrewarddiscount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setPsRewardDiscount(-$discount);
        return $this;
    }
}