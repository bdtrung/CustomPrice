<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CustomPrice
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CustomPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;
use Mageplaza\CustomPrice\Block\Product\View\CustomPrice;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SetCustomPrice
 * @package Mageplaza\CustomPrice\Observer
 */
class SetCustomPrice implements ObserverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CustomPrice
     */
    protected $customPrice;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CustomPrice $customPrice
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->customPrice = $customPrice;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $isEnabled = $this->scopeConfig->getValue('mpcustomprice/general/enabled', ScopeInterface::SCOPE_STORE);

        if ($isEnabled) {
            $item = $observer->getEvent()->getData('quote_item');
            $item = ($item->getParentItem() ? $item->getParentItem() : $item);
            $rule = $this->customPrice->getRule($item->getSku());
            if ($rule) {
                $item->setCustomPrice($rule->getCustomPrice());
                $item->setOriginalCustomPrice($rule->getCustomPrice());
                $item->getProduct()->setIsSuperMode(true);
            }
        }

    }
}
