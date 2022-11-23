<?php

namespace Abhay\PackingCharge\Model\Total;

class PackingCharge extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator
    ) {
        $this->quoteValidator = $quoteValidator;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/model.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        
        $packingCharge = $quote->getPackingCharge();

        $logger->info($packingCharge);
        
        $total->setPackingCharge($packingCharge);
        $total->setPackingCharge($packingCharge);

        $total->setTotalAmount('packing_charge', $packingCharge);
        $total->setBaseTotalAmount('packing_charge', $packingCharge);

        return $this;
    }

    /**
     * Setting for clearing the grand total values
     *
     * @param Total $total
     */
    protected function clearValues(
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setTotalAmount('packing_charge', 0);
        $total->setBaseTotalAmount('packing_charge', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    
    public function fetch(
        \Magento\Quote\Model\Quote $quote, 
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        return [
            'code' => 'packing_charge',
            'title' => 'Packing Charge',
            'value' => $quote->getCoreCharge()
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Packing Charge');
    }
}
