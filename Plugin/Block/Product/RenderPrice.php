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

namespace Mageplaza\CustomPrice\Plugin\Block\Product;

use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Mageplaza\CustomPrice\Block\Product\View\CustomPrice;

/**
 * Class RenderPrice
 * @package Mageplaza\CustomPrice\Plugin\Block\Product
 */
class RenderPrice
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
     * RenderPrice constructor.
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
     * @param ListProduct $subject
     * @param $result
     * @param $product
     *
     * @return mixed
     * @throws LocalizedException
     */
    public function afterGetProductPrice(ListProduct $subject, $result, $product)
    {
        $isEnabled = $this->scopeConfig->getValue('mpcustomprice/general/enabled', ScopeInterface::SCOPE_STORE);
        $rule      = $this->customPrice->getRule($product->getSku());

        if ($isEnabled && $rule) {
            return $subject->getLayout()
                ->createBlock(CustomPrice::class)
                ->setTemplate('Mageplaza_CustomPrice::category/customprice.phtml')
                ->setProduct($product)
                ->toHtml();
        }

        return $result;
    }
}
