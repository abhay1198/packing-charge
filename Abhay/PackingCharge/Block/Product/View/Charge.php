<?php

namespace Abhay\PackingCharge\Block\Product\View;

class Charge extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\CurrencyInterface $localeCurrency
    ) {
        $this->registry = $registry;
        $this->_productFactory = $productFactory;
        $this->_storeManager = $storeManager;
        $this->_localeCurrency = $localeCurrency;
		parent::__construct($context);
	}

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get Product Collection
     *
     * @param int $productId
     * @return object Magento\Catalog\Model\Product
     */
    public function getProductCollection($productId)
    {
        return $this->_productFactory->create()->load($productId);
    }

    /**
     * Retrieve currency Symbol.
     *
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->_localeCurrency->getCurrency(
            $this->getBaseCurrencyCode()
        )->getSymbol();
    }

    public function getBaseCurrencyCode()
    {
        return $this->_storeManager->getStore()->getBaseCurrencyCode();
    }
}