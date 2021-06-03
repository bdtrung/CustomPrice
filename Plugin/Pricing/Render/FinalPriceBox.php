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

namespace Mageplaza\CustomPrice\Plugin\Pricing\Render;

use Magento\Store\Model\ScopeInterface;
use Mageplaza\CustomPrice\Block\Product\View\CustomPrice;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class FinalPriceBox
 * @package Mageplaza\CustomPrice\Pricing\Render
 */
class FinalPriceBox
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
     * FinalPriceBox constructor.
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
     * @param $subject
     * @param $html
     *
     * @return mixed
     */
    public function afterToHtml($subject, $html)
    {
        $isEnabled = $this->scopeConfig->getValue('mpcustomprice/general/enabled', ScopeInterface::SCOPE_STORE);
        if ($isEnabled) {
            $productSku = $subject->getSaleableItem()->getSku();
            $rule       = $this->customPrice->getRule($productSku);

            if ($rule) {
                $customPrice = $subject->getLayout()
                    ->createBlock(CustomPrice::class)
                    ->setTemplate('Mageplaza_CustomPrice::customprice.phtml')
                    ->setProduct($subject->getSaleableItem())
                    ->toHtml();

                return $customPrice;
            }
        }

        return $html;
    }
}
