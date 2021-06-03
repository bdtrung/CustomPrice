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

namespace Mageplaza\CustomPrice\Plugin\Model;

use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Store\Model\ScopeInterface;
use Mageplaza\CustomPrice\Block\Product\View\CustomPrice;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SetCustomPrice
 * @package Mageplaza\CustomPrice\Plugin\Model
 */
class SetCustomPrice
{
    /**
     * @var CustomPrice
     */
    protected $customPrice;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * SetCustomPrice constructor.
     *
     * @param CustomPrice $customPrice
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        CustomPrice $customPrice,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customPrice = $customPrice;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param AbstractItem $subject
     */
    public function beforeGetCalculationPriceOriginal(AbstractItem $subject)
    {
        $isEnabled = $this->scopeConfig->getValue('mpcustomprice/general/enabled', ScopeInterface::SCOPE_STORE);

        /** @var $item Item */
        if ($isEnabled) {
            foreach ($subject->getQuote()->getAllItems() as $item) {
                $rule = $this->customPrice->getRule($item->getSku());
                if ($rule) {
                    $item->setOriginalCustomPrice($rule->getCustomPrice());
                } else {
                    $item->setOriginalCustomPrice(null);
                }
            }
        } else {
            foreach ($subject->getQuote()->getAllItems() as $item) {
                $item->setOriginalCustomPrice(null);
            }
        }
    }
}
